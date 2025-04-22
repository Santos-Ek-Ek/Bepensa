<?php

namespace App\Http\Controllers;

use App\Models\CFDI;
use App\Models\Cliente;
use App\Models\Facturacion;
use App\Models\FacturacionProducto;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Proveedor::where('activo', 1)->get();
        $clientes = Cliente::where('activo', 1)->get();
        $cfdis = CFDI::where('activo', 1)->get();
        $productos = Producto::all();
        return view('facturacion.nueva-facturacion', compact(
            'proveedores', 
            'clientes', 
            'cfdis',
            'productos', 
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    // Validar los datos
    $validated = $request->validate([
        'cliente_id' => 'required',
        'cfdi_id' => 'required',
        'total' => 'required|numeric|min:0',
        'productos' => 'required|array|min:1',
        'productos.*' => 'exists:productos,id',
        'cantidades' => 'required|array|min:1',
        'cantidades.*' => 'integer|min:1'
    ], [
        'cliente_id.required' => 'El cliente es requerido',
        'cfdi_id.required' => 'El CFDI es requerido',
        'total.required' => 'El total es requerido',
        'productos.required' => 'Debe agregar al menos un producto',
        'productos.min' => 'Debe agregar al menos un producto',
        'cantidades.required' => 'Las cantidades son requeridas',
        'cantidades.min' => 'Debe especificar cantidades para todos los productos',
        'cantidades.*.min' => 'La cantidad mínima es 1'
    ]);

    try {
        DB::beginTransaction();

        $facturacion = Facturacion::create([
            'cliente_id' => $request->cliente_id,
            'cfdi_id' => $request->cfdi_id,
            'forma_pago' => 'EFECTIVO',
            'codigo' => 'FAC-' . time(),
            'total' => $request->total,
            'vencimiento' => now()->addDays(30),
            'estatus' => 'PENDIENTE',
            'activo' => 1
        ]);

        foreach ($request->productos as $key => $producto_id) {
            $cantidad = $request->cantidades[$key];
            $producto = Producto::find($producto_id);
            $subtotal = $producto->precio * $cantidad;

            FacturacionProducto::create([
                'facturacion_id' => $facturacion->id,
                'producto_id' => $producto_id,
                'precio' => $producto->precio,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal,
            ]);
        }

        DB::commit();

        if(Session::get('usuario')) {
            $this->generarCorreoEstatus(Session::get('usuario_id'), $facturacion->id);
        }

        return redirect()->route('cobro')->with('success', 'Facturación creada exitosamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()->with('error', 'Error al crear la facturación: ' . $e->getMessage());
    }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generarCorreoEstatus($usuario_id, $facturacion_id){
        try {
            $usuarioCorreoPrincipal = Usuario::select('id','correo')->where('id', $usuario_id)->where('activo', 1)->first();

            // Devolver los correos de los 
            $usuarioCorreoCC = Usuario::where('activo', 1)
                ->where('id', '!=', $usuarioCorreoPrincipal->id)
                ->whereNotNull('correo') 
                ->pluck('correo')
                ->toArray();
    
            $factura = Facturacion::with(['cliente:id,nombre_tienda,cod_cte,rfc,direccion,propietario',
                'cfdi:id,folio,nombre', 'productosFactura' => function($query) {
                $query->where('activo', 1)
                      ->with(['producto' => function($q) {
                          $q->select('id', 'codigo', 'nombre');
                      }]);
            }])
            ->where('id', $facturacion_id)
            ->firstOrFail();
        
            if ($factura->productosFactura->isEmpty()) {
                throw new \Exception("La factura no tiene productos asociados");
            }
        
            $subtotal = $factura->productosFactura->sum('subtotal');
        
            $data = [
                'factura' => $factura,
                'productos' => $factura->productosFactura,
                'subtotal' => $subtotal,
                'total' => $factura->total,
                'fecha' => $factura->created_at->format('Y-m-d'),
                'fecha_vencimiento' => date('d-m-Y', strtotime($factura->vencimiento)),
                'dias_restantes' => $factura->dias_restantes != null ? $factura->dias_restantes : null,
                'factura_codigo' => $factura->codigo,
                'factura_estatus' => $factura->estatus,
                'cliente_tienda' => $factura->cliente->nombre_tienda ?? 'No especificado',
                'propietario' => $factura->cliente->propietario ?? 'No especificado',
                'cod_cte' => $factura->cliente->cod_cte ?? 'No especificado',
                'rfc' => $factura->cliente->rfc ?? 'No especificado',
                'direccion' => $factura->cliente->direccion ?? 'No especificado',
                'cfdi_tipo' => ($factura->cfdi ? $factura->cfdi->folio . ' - ' . $factura->cfdi->nombre : 'No especificado')
            ];

            // Definir el texto del estatus para el subject
            $estatusText = '';
            switch($factura->estatus) {
                case 'PENDIENTE':
                    $estatusText = 'Confirmado';
                    break;
                case 'CANCELADO':
                    $estatusText = 'Cancelado';
                    break;
                case 'PAGADO':
                    $estatusText = 'Pagado';
                    break;
                default:
                    $estatusText = '';
            }
    
            Mail::send('facturacion.factura-correo-estatus', $data, function ($message) use ($usuarioCorreoPrincipal, $usuarioCorreoCC, $factura, $estatusText) {
                $message->to($usuarioCorreoPrincipal->correo, $usuarioCorreoPrincipal->nombre);
                        
                if (!empty($usuarioCorreoCC)) {
                    $message->cc($usuarioCorreoCC);
                }
    
                $message->subject('Facturación ' . $factura->codigo . ' ' . $estatusText);
    
            });
        } catch (\Exception $e) {
            Log::error("Error generar el correo: " . $e->getMessage());
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
}
