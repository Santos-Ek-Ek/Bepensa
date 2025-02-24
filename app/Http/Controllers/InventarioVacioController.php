<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioVacioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $inventarios = DB::select('SELECT categorias.nombre as categoria, productos.codigo, productos.nombre as producto,
                                inventarios.id, inventarios.paletas, inventarios.saldos_c_tarimas,
                                inventarios.saldos_s_tarimas, inventarios.total
                                FROM inventarios INNER JOIN productos ON inventarios.id_producto=productos.id
                                JOIN categorias ON productos.id_categoria=categorias.id
                                JOIN tipos ON categorias.id_tipo= tipos.id
                                WHERE tipos.id=3;');
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
        $vacios=new Inventario();
        $vacios->paletas=$request->get('paletas');
        $vacios->saldos_c_tarimas=$request->get('saldos_c_tarimas');
        $vacios->saldos_s_tarimas=$request->get('saldos_s_tarimas');
        $vacios->total=$request->get('total');
        $vacios->id_producto=$request->get('id_producto');


        $vacios->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $vacios = Inventario::find($id);
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
        $vacios=Inventario::find($id);
        $vacios->paletas=$request->get('paletas');
        $vacios->saldos_c_tarimas=$request->get('saldos_c_tarimas');
        $vacios->saldos_s_tarimas=$request->get('saldos_s_tarimas');
        $vacios->total=$request->get('total');
        $vacios->id_producto=$request->get('id_producto');


        $vacios->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventarios= Inventario::find($id);
        $inventarios->delete();
    }
}
