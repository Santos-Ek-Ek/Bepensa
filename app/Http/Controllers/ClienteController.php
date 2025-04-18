<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::where('activo', 1)->get();
        return view('clientes.clientes', compact('clientes'));
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
            'nombre_tienda' => 'required|string',
            'propietario'   => 'required|string',
            'cod_cte'       => 'required|string',
            'rfc'           => ['required','string','regex:/^([A-Z&Ñ]{3}[0-9]{6}[A-Z0-9]{3}|[A-Z&Ñ]{4}[0-9]{6}[A-Z0-9]{3})$/i'
            ],
            'direccion'     => 'required|string',
        ], [
            'nombre_tienda.required' => 'El nombre de la tienda es obligatorio',
            'propietario.required' => 'El propietario es obligatorio',
            'cod_cte.required' => 'El código cte es obligatorio',
            'rfc.required' => 'El RFC es obligatorio',
            'rfc.size' => 'El RFC debe tener 12 caracteres (Persona Moral) o 13 caracteres (Persona Física) y un formato válido',
            'rfc.regex' => 'El RFC no tiene un formato válido.',
            'direccion.required' => 'La dirección es obligatoria' 
        ]);
    
        Cliente::create($request->all());
    
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
    // Validación
    $request->validate([
        'nombre_tienda' => 'required|string',
        'propietario'   => 'required|string',
        'cod_cte'       => 'required|string',
        'rfc'           => ['required','string','regex:/^([A-Z&Ñ]{3}[0-9]{6}[A-Z0-9]{3}|[A-Z&Ñ]{4}[0-9]{6}[A-Z0-9]{3})$/i'
        ],
        'direccion'     => 'required|string',
    ], [
        'nombre_tienda.required' => 'El nombre de la tienda es obligatorio',
        'propietario.required' => 'El propietario es obligatorio',
        'cod_cte' => 'El código cte es obligatorio',
        'rfc.required' => 'El RFC es obligatorio',
        'rfc.size' => 'El RFC debe tener 12 caracteres (Persona Moral) o 13 caracteres (Persona Física) y un formato válido',
        'rfc.regex' => 'El RFC no tiene un formato válido.',
        'direccion.required' => 'La dirección es obligatoria' 
    ]);

    // Buscar el cliente
    $cliente = Cliente::find($id);

    // Actualizar los datos
    $cliente->update([
        'nombre_tienda' => $request->nombre_tienda,
        'propietario' => $request->propietario,
        'cod_cte' => $request->cod_cte,
        'rfc' => $request->rfc,
        'direccion' => $request->direccion,
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
        $cliente = Cliente::find($id);
        if ($cliente) {
            $cliente->update([
                'activo' => 0,
            ]);
            $cliente->save();
            return redirect()->back()->with('success', 'Cliente eliminado correctamente.');
        }
        return redirect()->back()->with('error', 'Cliente no encontrado.');
    }
}
