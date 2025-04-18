<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Session;
use Redirect;
use Cache;
use Cookie;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function validar(Request $request)
    {
        // Validación de los campos de entrada
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string'
        ]);
    
        // Buscar el usuario (sin la contraseña primero para evitar timing attacks)
        $usuario = Usuario::where('usuario', $request->usuario)->where('activo', 1)->first();
    
        // Verificar si el usuario existe y la contraseña es correcta
        if ($usuario && $this->verificarCredenciales($usuario, $request->password)) {
            // Crear sesión con más datos relevantes
            Session::put([
                'usuario' => $usuario->nombre . ' ' . $usuario->apellidos,
                'usuario_id' => $usuario->id,
                'rol' => $usuario->rol,
                'ultimo_acceso' => now()
            ]);
    
            // Redirección basada en el rol
            return $this->redireccionarPorRol($usuario->rol);
        }
    
        // Manejo de credenciales incorrectas
        return redirect('/')->withErrors([
            'credenciales' => 'Usuario o contraseña incorrectos'
        ]);
    }
    protected function verificarCredenciales($usuario, $password)
    {
        // Implementación básica (debes usar hash en la práctica)
        
        
        // Implementación recomendada con hash:
        return Hash::check($password, $usuario->password);
    }

    protected function redireccionarPorRol($rol)
{
    $rutasPorRol = [
        'Administrador' => 'usuarios',
        'Usuario' => 'cobro',
        // Puedes agregar más roles y rutas aquí
    ];

    return redirect($rutasPorRol[$rol] ?? 'cobro');
}
    public function salir(){
        Session::flush();
        Session::reflash();
        Cache::flush();
        Cookie::forget('laravel_session');
        unset($_COOKIE);
        unset($_SESSION);
        return Redirect::to('/');
    }
}
