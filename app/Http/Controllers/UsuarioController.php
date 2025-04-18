<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Usuario::where('activo', 1)->get();
        return view('usuarios.usuarios', compact('usuarios'));
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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'usuario' => [
                'required',
                'string',
                'max:255',
                Rule::unique('usuarios')->where(function ($query) {
                    return $query->where('activo', 1);
                })
            ],
            'password' => 'required|string|min:8',
            'rol' => 'required|in:Administrador,Usuario'
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'apellidos.required' => 'Los apellidos es obligatorio',
            'usuario.required' => 'El usuario es obligatorio',
            'usuario.unique' => 'Ya existe un usuario activo con ese nombre',
            'password.required' => 'La contraseña es obligatoria',
            'rol.required' => 'El rol es obligatorio' 
        ]);
    
        try {
            $usuario = Usuario::create([
                'nombre' => $request->nombre,
                'apellidos' => $request->apellidos,
                'usuario' => $request->usuario,
                'password' => Hash::make($request->password),
                'rol' => $request->rol,
                'activo' => 1
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Usuario agregado correctamente',
                'usuario' => $usuario
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $usuarios = Usuario::find($id);
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
        //
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'usuario' => 'required|string|max:255|unique:usuarios,usuario,' . $id,
            'password' => 'nullable|string|min:8',
            'rol' => 'required|in:Administrador,Usuario'
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'apellidos.required' => 'Los apellidos es obligatorio',
            'usuario.required' => 'El usuario es obligatorio',
            'rol.required' => 'El rol es obligatorio' 
        ]);
    
        try {
            $usuario = Usuario::find($id);
            $usuario->nombre = $request->nombre;
            $usuario->apellidos = $request->apellidos;
            $usuario->usuario = $request->usuario;
            $usuario->rol = $request->rol;
        
            // Solo actualiza la contraseña si se escribió
            if ($request->filled('password')) {
                $usuario->password = Hash::make($request->password);
            }

            $usuario->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente',
                'usuario' => $usuario
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el usuario: ' . $e->getMessage()
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
        try {
            $usuario = Usuario::findOrFail($id);
            
            // Verificar si el usuario que intenta desactivar no es él mismo
            if (Auth::id() == $usuario->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes eliminar tu propio usuario'
                ], 403);
            }
            
            // Actualizar el campo activo a 0 (inactivo)
            $usuario->activo = 0;
            $usuario->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }
}
