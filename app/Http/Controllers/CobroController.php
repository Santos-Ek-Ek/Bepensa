<?php

namespace App\Http\Controllers;

use App\Models\Facturacion;
use App\Models\FacturacionProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cobros = Facturacion::where('activo', 1)->with('cliente', 'productos.producto')->orderBy('id', 'desc')->get();
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
}
