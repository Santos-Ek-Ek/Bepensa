<?php

namespace App\Http\Controllers;

use App\Models\CFDI;
use App\Models\Cliente;
use App\Models\Facturacion;
use App\Models\FacturacionProducto;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;

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
        $facturacion = Facturacion::create([
            'cliente_id' => $request->cliente_id,
            'cfdi_id' => $request->cfdi_id,
            'forma_pago' => 'EFECTIVO',
            'codigo' => 'FAC-' . time(),
            'activo' => 1
        ]);

        foreach ($request->productos as $key => $producto_id) {
            FacturacionProducto::create([
                'facturacion_id' => $facturacion->id,
                'producto_id' => $producto_id
            ]);
        }

        return redirect()->route('cobro')->with('success', 'Facturación creada exitosamente.');
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
