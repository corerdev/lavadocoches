@extends("layouts.basico")

@section('title','Listado de citas')

@section('contenido')


                
<table class="tableCitas">
<tr>
<td><strong>Fecha</td>
<td><strong>Hora de entrada y salida</strong></td>
<td><strong>Modelo de coche y matrícula</strong></td>
<td><strong>Tipo de lavado</strong></td>
<td><strong>Precio total</strong></td>
<td><strong>Teléfono</strong></td>
<!--Tras hacer la tabla hacemos un foreach con blade que vaya cogiendo los datos de la variable que le pasamos y haga las filas
    con ella-->
</tr>
@foreach($citas as $r)    
                    
<tr>
<td><!--Especial mención a lo facil que es usar fechas con carbon-->
    {{ \Carbon\Carbon::parse($r->entrada)->format('d-m-Y')}}
</td>
<td>
    {{ \Carbon\Carbon::parse($r->entrada)->format('H:i:s')}} - {{ \Carbon\Carbon::parse($r->salida)->format('H:i:s')}}
</td>

<td>
    {{$r->coche}} - {{$r->matricula}}
 </td>
 <td>
    {{$r->tipoLavado->descripcion}}
@if($r->llantas)
<img class="imgPequeListado" src="https://www.juntadeandalucia.es/educacion/gestionafp/datos/tareas/DAW/DWES_42625171/2023-24/DAW_DWES_2_2023-24_Individual__650793/rueda.png"></img>
@endif
</td>
<td>
    {{$r->precio}}
</td>
<td>
<img class="imgPequeListado" src="https://cdn2.iconfinder.com/data/icons/font-awesome/1792/phone-512.png" title="{{$r->nombre}} - {{$r->telefono}}">
</td>
</tr>
@endforeach
 </table>
@endsection