<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Session;
use Redirect;
use Cache;
use Cookie;

class LoginController extends Controller
{
    public function validar(Request $request){
        $usuario = $request->usuario;
        $password = $request->password;

        $coincidencia = Usuario::where('usuario', $usuario)->where('password', $password)->get();

        if(count($coincidencia)>0){
            $sesionActual = $coincidencia[0]->nombre .' '. $coincidencia[0]->apellidos;
            Session::put('usuario', $sesionActual);
            return Redirect::to('cobro');
        }else{
            return Redirect::to('/');
        }
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
