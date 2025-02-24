<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioNoRetornableController extends Controller
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
                                WHERE tipos.id=2;');
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
        $noretornables=new Inventario();
        $noretornables->paletas=$request->get('paletas');
        $noretornables->saldos_c_tarimas=$request->get('saldos_c_tarimas');
        $noretornables->saldos_s_tarimas=$request->get('saldos_s_tarimas');
        $noretornables->total=$request->get('total');
        $noretornables->id_producto=$request->get('id_producto');


        $noretornables->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $noretornables = Inventario::find($id);
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
        $noretornables=Inventario::find($id);
        $noretornables->paletas=$request->get('paletas');
        $noretornables->saldos_c_tarimas=$request->get('saldos_c_tarimas');
        $noretornables->saldos_s_tarimas=$request->get('saldos_s_tarimas');
        $noretornables->total=$request->get('total');
        $noretornables->id_producto=$request->get('id_producto');


        $noretornables->update();
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
