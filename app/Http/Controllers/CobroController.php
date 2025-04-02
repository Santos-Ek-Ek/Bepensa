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
    
            $factura = Facturacion::findOrFail($id);
            $factura->codigo = $request->codigo;
            $factura->total = $request->total;
            $factura->save();
    
            // 1. Manejar productos eliminados (marcar como inactivos)
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

                    FacturacionProducto::updateOrCreate(
                        [
                            'id' => $productoData['id'],
                            'facturacion_id' => $id
                        ],
                        [
                            'producto_id' => $productoData['producto_id'],
                            'cantidad' => $productoData['cantidad'],
                            'precio' => $productoData['precio'],
                            'subtotal' => $subtotal,
                            'activo' => 1 // Reactivar si estaba inactivo
                        ]
                    );
                }
            }
    
            // 3. Agregar nuevos productos (solo si no existen)
            if ($request->has('nuevos_productos')) {
                foreach ($request->nuevos_productos as $nuevoProducto) {
                    $subtotal = $nuevoProducto['cantidad'] * $nuevoProducto['precio'];

                    // Verificar si existe un registro inactivo para este producto
                    $existente = FacturacionProducto::where('facturacion_id', $id)
                        ->where('producto_id', $nuevoProducto['producto_id'])
                        ->first();

                    if ($existente) {
                        // Reactivar el existente
                        $existente->update([
                            'cantidad' => $nuevoProducto['cantidad'],
                            'precio' => $nuevoProducto['precio'],
                            'subtotal' => $subtotal,
                            'activo' => 1
                        ]);
                    } else {
                        // Crear nuevo registro
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
