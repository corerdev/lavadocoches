<?php

namespace App\View\Components;

use App\Models\TipoLavado;
use Illuminate\View\Component;

class SelectTipoLavado extends Component
{

    //Hacemos un select, parecido al que se nos proporcionaba de tipos de noticia, simplemente ligeramente adaptado

    public $listado;
    public $selectTipo;
    
   

    public function __construct($selectTipo)
    {
        $this->selectTipo =  $selectTipo;
        $this->listado = TipoLavado::orderByDesc('id')->get();
    }

    
    
    public function render()
    {
        return view('components.select-tipo-lavado');
    }
}