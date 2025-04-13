<?php

namespace App\Http\Controllers;

use App\Models\Facturacion;
use App\Models\FacturacionProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CobroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Facturacion::where('activo', 1)
            ->with('cliente', 'productos.producto')
            ->orderBy('id', 'desc');

        // Filtros flexibles por fecha
        if ($request->filled('start_date') && $request->filled('end_date')) {
            // Caso 1: Ambas fechas están presentes (rango completo)
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        } elseif ($request->filled('start_date')) {
            // Caso 2: Solo fecha de inicio (desde start_date en adelante)
            $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->filled('end_date')) {
            // Caso 3: Solo fecha de fin (hasta end_date)
            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        // Filtro por estatus (solo si se selecciona un valor diferente a "TODOS")
        if ($request->filled('status') && $request->status != '') {
            $query->where('estatus', $request->status);
        }

        $cobros = $query->get()->map(function ($factura) {
            // Calcular días restantes si existe fecha de vencimiento
            if ($factura->vencimiento) {
                $hoy = now();
                $vencimiento = Carbon::parse($factura->vencimiento);
                $diasCalculados = $hoy->diffInDays($vencimiento, false); // Calcula días con signo (puede ser negativo)
                // Asignamos 0 si es negativo o cero, de lo contrario el valor positivo
                $factura->dias_restantes = ($diasCalculados > 0) ? $diasCalculados : 0;

                if ($hoy->greaterThan($vencimiento) && $factura->estatus === 'PENDIENTE') {
                    $factura->estatus = 'CANCELADO';
                }

                // Cambiar estatus a CANCELADO si la fecha actual es POSTERIOR al vencimiento y NO es PAGADO
                $factura->save();
            }
            
            return $factura;
        });

        return view('cobro.cobro', compact('cobros'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
    
            // Validación de al menos un producto
            $productosCount = count($request->productos ?? []) + count($request->nuevos_productos ?? []);
            $productosEliminadosCount = count($request->productos_eliminados ?? []);
            
            if($productosCount === 0) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Debe incluir al menos un producto'
                ], 422);
            }
    
            $factura = Facturacion::findOrFail($id);
            $factura->codigo = $request->codigo;
            $factura->total = $request->total;
            $factura->save();
    
            // 1. Manejar productos eliminados
            if ($request->has('productos_eliminados')) {
                foreach ($request->productos_eliminados as $productoEliminado) {
                    FacturacionProducto::where('id', $productoEliminado['id'])
                        ->where('facturacion_id', $id)
                        ->update(['activo' => 0]);
                }
            }
    
            // 2. Actualizar productos existentes
            if ($request->has('productos')) {
                foreach ($request->productos as $productoData) {
                    $subtotal = $productoData['cantidad'] * $productoData['precio'];
                    
                    // Validación de cantidad
                    if($productoData['cantidad'] <= 0) {
                        throw new \Exception('La cantidad debe ser mayor a 0');
                    }
    
                    FacturacionProducto::updateOrCreate(
                        ['id' => $productoData['id'], 'facturacion_id' => $id],
                        [
                            'producto_id' => $productoData['producto_id'],
                            'cantidad' => $productoData['cantidad'],
                            'precio' => $productoData['precio'],
                            'subtotal' => $subtotal,
                            'activo' => 1
                        ]
                    );
                }
            }
    
            // 3. Agregar nuevos productos
            if ($request->has('nuevos_productos')) {
                foreach ($request->nuevos_productos as $nuevoProducto) {
                    $subtotal = $nuevoProducto['cantidad'] * $nuevoProducto['precio'];
                    
                    // Validación de cantidad
                    if($nuevoProducto['cantidad'] <= 0) {
                        throw new \Exception('La cantidad debe ser mayor a 0');
                    }
    
                    $existente = FacturacionProducto::where('facturacion_id', $id)
                        ->where('producto_id', $nuevoProducto['producto_id'])
                        ->first();
    
                    if ($existente) {
                        $existente->update([
                            'cantidad' => $nuevoProducto['cantidad'],
                            'precio' => $nuevoProducto['precio'],
                            'subtotal' => $subtotal,
                            'activo' => 1
                        ]);
                    } else {
                        FacturacionProducto::create([
                            'facturacion_id' => $id,
                            'producto_id' => $nuevoProducto['producto_id'],
                            'cantidad' => $nuevoProducto['cantidad'],
                            'precio' => $nuevoProducto['precio'],
                            'subtotal' => $subtotal,
                            'activo' => 1
                        ]);
                    }
                }
            }
    
            DB::commit();
    
            return response()->json([
                'success' => true, 
                'message' => 'Factura actualizada correctamente',
                'data' => $factura->load(['productos' => function($query) {
                    $query->where('activo', 1);
                }, 'productos.producto'])
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
    
            // Obtener la factura
            $factura = Facturacion::findOrFail($id);
    
            // 1. Pasar a activo 0 la facturación
            $factura->update(['activo' => 0]);
    
            // 2. Pasar a activo 0 todos los productos asociados
            FacturacionProducto::where('facturacion_id', $id)
                ->update(['activo' => 0]);
    
            DB::commit();
    
            // Redirección para solicitudes normales
            if (!request()->expectsJson()) {
                return redirect()->route('cobro')->with('success', 'Factura eliminada correctamente');
            }
    
            // Respuesta para AJAX
            return response()->json([
                'success' => true,
                'message' => 'Factura eliminada correctamente',
                'redirect' => route('facturacion.index')  // Agregamos la ruta de redirección
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Redirección para solicitudes normales
            if (!request()->expectsJson()) {
                return back()->with('error', 'Error al eliminar la factura: ' . $e->getMessage());
            }
    
            // Respuesta para AJAX
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la factura',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function generarPdf($facturaCodigo)
    {
        try {
            set_time_limit(180); // Increased timeout
            ini_set('memory_limit', '512M'); // Adequate memory
            
            // Eager load only what's needed
            $factura = Facturacion::with(['cliente:id,nombre_tienda,cod_cte,rfc,direccion,propietario',
                'cfdi:id,folio,nombre', 'productosFactura' => function($query) {
                $query->where('activo', 1)
                      ->with(['producto' => function($q) {
                          $q->select('id', 'codigo', 'nombre');
                      }]);
            }])
            ->where('codigo', $facturaCodigo)
            ->firstOrFail();
    
            if ($factura->productosFactura->isEmpty()) {
                throw new \Exception("La factura no tiene productos asociados");
            }
    
            $subtotal = $factura->productosFactura->sum('subtotal');
            $iva = $factura->total - $subtotal;
    
            $data = [
                'factura' => $factura,
                'productos' => $factura->productosFactura,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $factura->total,
                'fecha' => $factura->created_at->format('Y-m-d H:i:s'),
                'factura_codigo' => $factura->codigo,
                'cliente_nombre' => $factura->cliente->nombre_tienda ?? 'No especificado',
                'cod_cte' => $factura->cliente->cod_cte ?? 'No especificado',
                'rfc' => $factura->cliente->rfc ?? 'No especificado',
                'direccion' => $factura->cliente->direccion ?? 'No especificado',
                'propietario' => $factura->cliente->propietario ?? 'No especificado',
                'cfdi_tipo' => ($factura->cfdi ? $factura->cfdi->folio . ' - ' . $factura->cfdi->nombre : 'No especificado')
            ];
    
            // Use simpler PDF options
            $pdf = Pdf::loadView('facturacion.factura-pdf', $data)
                ->setPaper('legal', 'landscape')
                ->setOptions([
                    'defaultFont' => 'DejaVu Sans',
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                    'isCssFloatEnabled' => true,
                    'isFontSubsettingEnabled' => true,
                    'dpi' => 120,
                    'enable_css_float' => true,
                    'debugCss' => false,
                    'debugKeepTemp' => false,
                    'fontHeightRatio' => 0.9 
                ]);
    
            return $pdf->stream("factura-{$facturaCodigo}.pdf");
    
        } catch (\Exception $e) {
            Log::error("Error generando PDF: " . $e->getMessage());
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
}
