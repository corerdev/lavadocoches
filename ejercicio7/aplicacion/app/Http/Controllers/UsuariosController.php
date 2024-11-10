<?php

namespace App\Http\Controllers;
use App\Models\Usuarios;
use Illuminate\Http\Request;
//use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;   

class UsuariosController extends Controller
{
    
  
    public function login()
    {
        if(Auth::check()) 
        {
            return redirect()->route('citas.index');
        }

        return view('usuarios.login');
    }

    public function authenticate(Request $request)
    {
        $datos = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($datos)) {
            $request->session()->regenerate();
            return redirect()->route('citas.index');
        }

        return back()->withErrors([
            'username' => 'El usuario y la contraseña no son correctos',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('usuarios.login');
    }
}