<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $productos = Producto::all();
    }

    public function buscar(Request $request)
    {
        $query = $request->q;
        $productos = Producto::where('codigo', 'LIKE', "%$query%")
                    ->orWhere('nombre', 'LIKE', "%$query%")
                    ->limit(5)
                    ->get();
        return response()->json($productos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productos=new Producto();
        $productos->codigo=$request->get('codigo');
        $productos->nombre=$request->get('nombre');
        $productos->descripcion=$request->get('descripcion');
        $productos->id_categoria=$request->get('id_categoria');


        $productos->save();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $productos=Producto::find($id);
        $productos->codigo=$request->get('codigo');
        $productos->nombre=$request->get('nombre');
        $productos->descripcion=$request->get('descripcion');
        $productos->id_categoria=$request->get('id_categoria');


        $productos->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productos= Producto::find($id);
        $productos->delete();
    }
}
