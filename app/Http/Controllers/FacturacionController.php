<?php

namespace App\Http\Controllers;

use App\Models\CFDI;
use App\Models\Cliente;
use App\Models\Facturacion;
use App\Models\FacturacionProducto;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
