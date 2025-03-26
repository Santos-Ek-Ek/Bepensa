<?php

namespace App\Http\Controllers;

use App\Models\Facturacion;
use App\Models\FacturacionProducto;
use App\Models\Producto;
use Illuminate\Http\Request;

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
            $factura = Facturacion::findOrFail($id);
            $factura->codigo = $request->codigo;
            $factura->total = $request->total;
            $factura->save();
    
            // Actualizar productos
            if ($request->has('productos')) {
                foreach ($request->productos as $productoData) {
                    // Buscar el producto en la factura
                    $facturaProducto = FacturacionProducto::where('facturacion_id', $id)
                        ->where('id', $productoData['id'])
                        ->first();
    
                    if ($facturaProducto) {
                        $facturaProducto->cantidad = $productoData['cantidad'];
                        $facturaProducto->save();
                    }
                }
            }
    
            return response()->json([
                'success' => true, 
                'message' => 'Factura actualizada correctamente',
                'data' => $factura->load('productos.producto')
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error al actualizar la factura',
                'error' => $e->getMessage()
            ], 500);
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
        //
    }
}
