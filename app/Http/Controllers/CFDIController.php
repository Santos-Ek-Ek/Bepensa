<?php

namespace App\Http\Controllers;

use App\Models\CFDI;
use Illuminate\Http\Request;

class CFDIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cfdis= CFDI::where('activo', 1)->get();
        return view('cfdi.cfdi', compact('cfdis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cfdi = new CFDI();
        $cfdi->folio = $request->input("folio");
        $cfdi->nombre = $request->input("nombre");
        $cfdi->activo = 1;
        $cfdi->save();
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
        // Buscar el cliente
        $cfdi = CFDI::find($id);

        // Actualizar los datos
        $cfdi->update([
            'folio' => $request->folio,
            'nombre' => $request->nombre,
        ]);
                
        return redirect()->back()->with('success', 'CFDI actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cfdi = CFDI::find($id);
        if ($cfdi) {
            $cfdi->update([
                'activo' => 0,
            ]);
            $cfdi->save();
            return redirect()->back()->with('success', 'CFDI eliminado correctamente.');
        }
        return redirect()->back()->with('error', 'CFDI no encontrado.');
    }
}
