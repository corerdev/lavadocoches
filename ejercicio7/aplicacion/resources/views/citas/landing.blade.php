@extends("layouts.basico")

@section('title','Bienvenido')

@section('contenido')

<div class='landingDiv'>
<h2>Bienvenido al sistema de reservas de Elefante Azul</h2>
<img class='imgelefante' src='{{ asset('images\elefante.png') }}'/>
</div>


@endsection