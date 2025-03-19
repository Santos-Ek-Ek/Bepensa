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
        $request->validate([
            'folio' => 'required',
            'nombre' => 'required'
        ], [
            'folio.required' => 'El folio es obligatorio',
            'nombre.required' => 'El nombre es obligatorio'
        ]);

        CFDI::create($request->all());
        return response()->json(['success' => true]);
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
        $request->validate([
            'folio' => 'required',
            'nombre' => 'required'
        ], [
            'folio.required' => 'El folio es obligatorio',
            'nombre.required' => 'El nombre es obligatorio'
        ]);

        // Buscar el cliente
        $cfdi = CFDI::find($id);

        // Actualizar los datos
        $cfdi->update([
            'folio' => $request->folio,
            'nombre' => $request->nombre,
        ]);
                
        return response()->json(['success' => true]);
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
