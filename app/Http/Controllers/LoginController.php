<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login
     */


    /**
     * Procesa el intento de login
     */
    public function login(Request $request)
    {
        // Validación de campos
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ], [
            'usuario.required' => 'El campo usuario es obligatorio',
            'password.required' => 'El campo contraseña es obligatorio',
        ]);

        // Buscar usuario por nombre de usuario
        $user = Usuario::where('usuario', $request->usuario)->first();

        // Verificar usuario y contraseña
        if ($user && Hash::check($request->password, $user->password)) {
            // Autenticar al usuario manualmente
            Auth::login($user);
            Session::put([
                'usuario' => $user->nombre . ' ' . $user->apellidos,
                'usuario_id' => $user->id,
                'rol' => $user->rol,
            ]);
            $request->session()->regenerate();

            // Redirección según el rol
            switch ($user->rol) {
                case 'Administrador':
                    return redirect()->route('usuarios.index');
                case 'Usuario':
                    return redirect()->route('cobro.index');
                default:
                    return redirect()->intended('/');
            }
        }

        // Si la autenticación falla
        return back()->withErrors([
            'credenciales' => 'Usuario o contraseña incorrectos',
        ]);
    }

    /**
     * Cierra la sesión del usuario
     */
    public function salir(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}