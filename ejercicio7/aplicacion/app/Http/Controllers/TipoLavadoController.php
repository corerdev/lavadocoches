<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\TipoLavado;
use Illuminate\Support\Str;
use App\Rules\TipoVacio;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TipoLavadoController extends Controller
{   //funcion para mostrar el lavado, que solo nos lo da si estamos logeados
    public function listLavado()
    {
         if(Auth::check()==false) 
        {
            return redirect()->route('usuarios.login')->with('success', 'No tienes permiso, identifícate.');
        }
        
        return view('lavados.listLavado');
    }

    //funcion que nos elimina un lavado según la ID que le pasemos

    public function eliminarLavado(Request $request) {

        $lavado = TipoLavado::find($request->idLavado);
        $lavado->delete();

        return response()->json(['success'=>true]);
    }

    public function getListado(Request $request){
        
        //empezamos a construir el where
        $where = '';
        //comprobamos que el value no esté vacio. Si no lo está, seguimos construyendo la sentencia SQL con un where, donde
        //cada where será una columna que sea searchable, con los datos de esta
        if(!empty($request->search['value']))
        {
            $stringAdded = false;
            $where.= 'WHERE ';
            for ($i = 0; $i < count($request->columns); $i++) {

                $searchable = json_decode($request->columns[$i]['searchable']);
                
                if ($searchable) {
                    if ($stringAdded) {
                        $where.= ' OR ';
                    }

                    $where.= $request->columns[$i]['name'] .' LIKE \'%'. $request->search['value'] .'%\'';
                    $stringAdded = true; 
                }
                
            }
        }
        //hacemos el order by, según la columan que este en ese momento
        $orderBy = 'ORDER BY '. $request->columns[$request->order[0]['column']]['name'] .' '. $request->order[0]['dir'];
        //la paginación, segun la que tuvieramos puesta
        $paginacion = '';
        if ($request->length != -1) {
            $paginacion.='LIMIT '.$request->length.' OFFSET '.$request->start;
        }        
        //Y finalmente hacemos la busqueda con todos los datos que se le ha dado 
        $lavados = DB::select('SELECT * FROM tipo_lavado '. $where .' '. $orderBy .' '. $paginacion);
        //cogemos los datos para la paginación
        $recordsFiltered = DB::select('SELECT COUNT(id) as recordsNum FROM tipo_lavado '. $where)[0]->recordsNum;
        $recordsTotal = DB::select('SELECT COUNT(id) as recordsNum FROM tipo_lavado')[0]->recordsNum;
        
        $datos = array();
        //y finalmente cofemos los datos de la búsqueda y los pasamos como json
        foreach($lavados as $lavado) {
            $item = array();
            
            $item['id']=$lavado->id;
            $item['descripcion']=$lavado->descripcion;
            $item['precio']=$lavado->precio;
            $item['tiempo']=$lavado->tiempo;

            $datos[]=$item;
        }

        return response()->json(['draw' => $request->draw, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => $datos]);
    }
    
    //la función para ver la pagina de registro de lavado, una vez mas solo visible si estamos logeados
    public function regLavado()
    {
         if(Auth::check()==false) 
        {
            return redirect()->route('usuarios.login')->with('success', 'No tienes permiso, identifícate.');
        }
        
        return view('lavados.regLavado');
    }
    //la funcion de registro de lavado. Nos valida los datos que le hemos pasado desde la vista, y si no falla,
    //crea un nuevo tipo de lavado con esos datos, lo guarda, y finalmente manda un mensaje de success
    public function registrarLavado (Request $request) {      
        
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|unique:tipo_lavado|max:30',
            'tiempo' => 'required|min:1|numeric',
            'precio' => 'required|min:1|numeric'        
        ]);
    
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        else
        {
            $lavado = new TipoLavado();
            $lavado->descripcion = $request->descripcion;
            $lavado->tiempo = $request->tiempo;
            $lavado->precio = $request->precio;

            $lavado->save();

            return response()->json(['success'=>'Se ha registrado el tipo de lavado']);
        } 
    }
    //las funciones de las tres validaciones. Parecidas a la anterior, pero cada una solo valida un campo y manda un mensaje
    public function validarDescripcion (Request $request) {
        
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|unique:tipo_lavado|max:30',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        else
        {
            return response()->json(['success'=>true]);
        }    
    }

    public function validarTiempo (Request $request) {

        $validator = Validator::make($request->all(), [
            'tiempo' => 'required|min:1|integer',
        ]);
        
        if ($validator->fails())
        {
        return response()->json(['errors'=>$validator->errors()->all()]);
        }
        else
        {
            return response()->json(['success'=>true]);
        }
        
    }

    public function validarPrecio (Request $request) {
        
        $validator = Validator::make($request->all(), [
            'precio' => 'required|min:1|integer',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        else
        {
            return response()->json(['success'=>true]);
        }
        
    }

    
}