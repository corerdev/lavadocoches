<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anuncio;

use App\Models\TipoAnuncio;
use Illuminate\Support\Str;
use App\Rules\TipoVacio;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

//use Illuminate\Support\Facades\DB;

class AnuncioController extends Controller
{
    public function index()
    {
         if(Auth::check()==false) 
        {
            return redirect()->route('usuarios.login')->with('success', 'No tienes permiso, identifícate.');
        }

        $Anuncio = Anuncio::all();
        
        return view('Anuncio.index', compact('Anuncio'));
    }

    public function landing()
    {  
        return view('Anuncio.landing');
    }
    
    public function create()

    {
        return view('Anuncio.create');
    }
    
    public function store(Request $request)
    {   


        $datos = $request->validate([
            
            
            'nombre' => 'required|max:30|regex:/^[A-Za-z]+$/',
            'telefono' => 'required|min:9|max:9|regex:/^[679][0-9]{8}$/',
            'entrada' => 'required|date|after:today',
            'coche' => 'required|max:50',
            'matricula' => 'required|max:7|regex:/^[0-9]{4}[A-Za-z]{3}$/',
            'tipo_lavado' => 'required|max:36'
            
            
        ]);

        $lavado = TipoAnuncio::where('descripcion', $datos['tipo_lavado'])->first();
        $precio = $lavado->precio;
        $tiempoLavado = $lavado->tiempo;
        $TipoAnuncio = $lavado->id;
        $nombreLavado = $lavado->descripcion;

        $horaMinuto = Carbon::createFromTime(rand(8, 15), rand(0,1)*30);
        $datosEntrada = Carbon::parse($datos['entrada'])->settime($horaMinuto->hour, $horaMinuto->minute);
        $datos['entrada'] = $datosEntrada->format('Y-m-d H:i:s');

        $llevaLlantasTicket = 'No'; 

        $llantasSiONo = 0;
        $costeLlantas = 0;
            if ($request->llantas == "on") {
                $llantasSiONo = '1';
                $llevaLlantasTicket = 'Si';
                $costeLlantas = 15;
                $tiempoLavado = $tiempoLavado + 15;}
        $datos['llantas'] = $llantasSiONo; 
        $datos['precio'] = $precio + $costeLlantas; 

        $datos['salida'] = Carbon::parse($datosEntrada->addMinute($tiempoLavado)->format('Y-m-d H:i:s'));
        

        $datos['tipo_lavado'] = $TipoAnuncio;

        Anuncio::create($datos);


        return view('Anuncio.ticket', compact('datos', 'tiempoLavado', 'nombreLavado', 'llevaLlantasTicket'));
    }

    //  --------------- Función de la API  --------------------------------------

    public function api(Request $request)
    {

        $datosApi = $request->all(); //Guardamos el request en una variable
        $datosApi['entrada'] = Carbon::createFromFormat('d/m/Y', $datosApi['entrada']); //Modificamos la entrada para que sea un date,
        //ya que me estaba dando problemas, indicando que no era válida
        

        // Realizo la comprobación de que el tipo de lavado es correcto antes de hacer el validator ya que no se como
        // hacerlo en el validator
        if(!$datosApi['tipo_lavado']=='Básico' && !$datosApi['tipo_lavado']=='Completo' && !$datosApi['tipo_lavado']=='Premium'){
             $errorLavado = array();
             $errorLavado['lavado'] = 'El tipo de lavado no es correcto';
             return response()->json([
                'esValido' => false,
                'listaErrores' => $errorLavado
            ], 401);
        }

        $validacion = Validator::make( $datosApi,  // Pasamos los datos por el validatos, excepto las llantas
        [
             'nombre' => 'required|max:30|regex:/^[A-Za-z]+$/',
             'telefono' => 'required|min:9|max:9|regex:/^[679][0-9]{8}$/',
             'entrada' => 'required|date|after:today',
             'coche' => 'required|max:50',
             'matricula' => 'required|max:7|regex:/^[0-9]{4}[A-Za-z]{3}$/',
             'tipo_lavado' => 'required|max:36'
        ]);

        // En caso de que el validator no sea correcto, no esperamos a realizar más operaciones, sino que simplemente
        // mandamos la respuesta en el momento

        if($validacion->fails())
        {
            return response()->json([
                'esValido' => false,
                'listaErrores' => $validacion->errors()
            ], 401);
        }
        
        $lavado = TipoAnuncio::where('descripcion', $datosApi['tipo_lavado'])->first();
        $precio = $lavado->precio;
        $tiempoLavado = $lavado->tiempo;
        $TipoAnuncio = $lavado->id;
        $nombreLavado = $lavado->descripcion;

        $horaMinuto = Carbon::createFromTime(rand(8, 15), rand(0,1)*30);
        $datosEntrada = Carbon::parse($datosApi['entrada'])->settime($horaMinuto->hour, $horaMinuto->minute);
        $datosApi['entrada'] = $datosEntrada->format('Y-m-d H:i:s');

        $llevaLlantasTicket = 'No'; 

        $llantasSiONo = 0;
        $costeLlantas = 0;
            if ($request->llantas == "on") {
                $llantasSiONo = '1';
                $llevaLlantasTicket = 'Si';
                $costeLlantas = 15;
                $tiempoLavado = $tiempoLavado + 15;}
        $datosApi['llantas'] = $llantasSiONo; 
        $datosApi['precio'] = $precio + $costeLlantas; 

        // La gran parte del código es la misma que en el store, ya que tenemos que seguir los mismos pasos para poder hacer el
        // create. La parte que cambia es lo que vamos a devolver. En lugar de hacer como en store, en el que simplemente
        // pasamos las variables conforme las teniamos, aquí vamos a hacer una variable específica para madnar por la API.
        // Hacemos esto para evitar mandar más datos de los necesarios; por ejemplo, si simplemente mandase datosApi mandaría gran
        // parte de los datos necesarios (tal y como se hacía en el store), pero también mandaría datos que no es necesario mandar,
        // como la id de los lavados.

        $entradaBonita = $datosEntrada->format('Y-m-d H:i');
        $datosApi['salida'] = Carbon::parse($datosEntrada->addMinute($tiempoLavado)->format('Y-m-d H:i:s'));
        $salidaBonita = $datosApi['salida']->format('Y-m-d H:i');
        $datosApi['tipo_lavado'] = $TipoAnuncio;

        // En esta variable guardamos todos los datos que tenemos que mandar por la API

        $datosApiEnvio = array();
        $datosApiEnvio['nombre'] = $datosApi['nombre'];
        $datosApiEnvio['telefono'] = $datosApi['telefono'];
        $datosApiEnvio['coche'] = $datosApi['coche'];
        $datosApiEnvio['matricula'] = $datosApi['matricula'];
        $datosApiEnvio['precio'] = $datosApi['precio'];
        $datosApiEnvio['tiempoLavado'] = $tiempoLavado;
        $datosApiEnvio['nombreLavado'] = $nombreLavado;
        $datosApiEnvio['salidaBonita'] = $salidaBonita;
        $datosApiEnvio['entradaBonita'] = $entradaBonita;
        $datosApiEnvio['llantas'] = $llantasSiONo;

        // Sabiendo que, llegado a este punto, el validator ha funcionado, simplemente hacemos el create y mandamos la respuesta
     
        Anuncio::create($datosApi);

        return response()->json([
            'esValido' => true,
            'datosTicket' => $datosApiEnvio
        ], 200);
        

        
    }

    
}