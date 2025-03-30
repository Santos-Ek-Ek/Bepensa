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
    
            // Group products by product_id to sum quantities
            $groupedProducts = [];
            if ($request->has('productos')) {
                foreach ($request->productos as $productoData) {
                    $productId = $productoData['producto_id'];
                    if (!isset($groupedProducts[$productId])) {
                        $groupedProducts[$productId] = $productoData;
                    } else {
                        $groupedProducts[$productId]['cantidad'] += $productoData['cantidad'];
                    }
                }
            }

            // Update existing products
            foreach ($groupedProducts as $productData) {
                $facturaProducto = FacturacionProducto::where('facturacion_id', $id)
                    ->where('id', $productData['id'])
                    ->first();

                if ($facturaProducto) {
                    $facturaProducto->cantidad = $productData['cantidad'];
                    $facturaProducto->subtotal = $productData['cantidad'] * $productData['precio'];
                    $facturaProducto->save();
                }
            }

            // Add new products
            if ($request->has('nuevos_productos')) {
                $groupedNewProducts = [];
                foreach ($request->nuevos_productos as $nuevoProducto) {
                    $productId = $nuevoProducto['producto_id'];
                    if (!isset($groupedNewProducts[$productId])) {
                        $groupedNewProducts[$productId] = $nuevoProducto;
                    } else {
                        $groupedNewProducts[$productId]['cantidad'] += $nuevoProducto['cantidad'];
                    }
                }

                foreach ($groupedNewProducts as $nuevoProducto) {
                    FacturacionProducto::create([
                        'facturacion_id' => $id,
                        'producto_id' => $nuevoProducto['producto_id'],
                        'cantidad' => $nuevoProducto['cantidad'],
                        'precio' => $nuevoProducto['precio'],
                        'subtotal' => $nuevoProducto['cantidad'] * $nuevoProducto['precio']
                    ]);
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
