<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class GoogleController extends Controller
{
  
     public function handleGoogleCallback()
     {
         try {

            //Guardamos en una variable el usuario que google nos devuelve
 
             $usuarioGoogle = Socialite::driver('google')->user();

            //Y comprobamos si está en la base de datos

             $existeUsuario = Usuarios::where('google_id', $usuarioGoogle->id)->first();

            //Si está, simplemente nos logeamos con el y volvemos a citas

             if($existeUsuario)
             {       
                Auth::login($existeUsuario);
                return redirect()->route('citas.index');
             }
             else //Si no, procedemos a crear el usuario, nos logeamos con el y vamos a citas
             {                
                $datos = array();
                $datos['username'] = $usuarioGoogle->email;
                $datos['google_id'] = $usuarioGoogle->id;
                $datos['password'] = Hash::make('1234');
                        
                $nuevoUsuario = Usuarios::create($datos);


                Auth::login($nuevoUsuario);
 

                return redirect()->route('citas.index');

             }         
 
         } 
         catch (Exception $e) 
         {
            return redirect()->route('usuarios.login')->withErrors([
                'google' => $e->getMessage()
            ]);
         }
 
     }

    //Una simple función que nos redirige a google

     public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

}