@extends("layouts.basico")

@section('title','Ticket de la cita')

@section('contenido')

<!--Cogemos las variables que le damos a la pagina y las vamos ordenando y dando formato para ver el ticket-->

<div class='ticketDiv'>

  <h2>Ticket de reserva</h2>

  <h3>Datos del cliente</h3>

  <div class='campo'>
    <span class='etiqueta'>Nombre - </span><span> {{$datos['nombre']}}</span><br>
    <span class='etiqueta'>Telefono - </span><span> {{$datos['telefono']}}</span><br>
    <span class='etiqueta'>Coche - </span><span> {{$datos['coche']}}</span><br>
    <span class='etiqueta'>Matricula - </span><span> {{$datos['matricula']}}</span>
  </div>

  <h3>Datos del lavado</h3>

  <div class='campo'>
    <span class='etiqueta'>Lavado reservado - </span><span> {{$nombreLavado}}</span><br>
    <span class='etiqueta'>Precio total del lavado - </span><span> {{$datos['precio']}} €</span><br>
    <span class='etiqueta'>Reserva de llantas - </span><span> {{$llevaLlantasTicket}}</span>

  </div>

  <h3>Horario de la reserva</h3>

  <div class='campo'>
    <span class='etiqueta'>Tiempo total del lavado - </span><span> {{$tiempoLavado}} minutos</span><br>
    <span class='etiqueta'>Hora de entrada - </span><span> {{$datos['entrada']}}</span><br>
    <span class='etiqueta'>Hora de salida - </span><span> {{$datos['salida']}}</span>
  </div>

@endsection