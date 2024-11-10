@extends("layouts.basico")

@section('title','Reservar cita')

@section('contenido')

<!--Por suerte o por desgracia no tengo demasiado que comentar en las vistas de Laravel, ya que al final del dia simplemente
ha sido trabajar html, aunque con las comodidades que ofrece Laravel. Aunque al principio intimidaba un poco, lo cierto esque
Laravel es una ayuda tremenda con todo el tema de php y estoy bastante contento tanto con el resultado, como con el entorno en si -->

  <h2>Reservar cita</h2>
  <form action="{{ route('citas.store') }}" method="post">
        @csrf
        <div class="form-group">
          <label for="title">Nombre</label><br>
          <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}"/>
            @error('nombre')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
          <label for="title">Telefono</label><br>
          <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}"/>
            @error('telefono')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
          <label for="title">Coche</label><br>
          <input type="text" class="form-control" id="coche" name="coche" value="{{ old('coche') }}"/>
            @error('coche')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
          <label for="title">Matricula</label><br>
          <input type="text" class="form-control" id="matricula" name="matricula" value="{{ old('matricula') }}"/>
            @error('matricula')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
          <label for="title">Limpieza de llantas (15€)</label>
          <input type="checkbox" class="form-control" id="llantas" name="llantas"/>
            @error('llantas')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
          <label for="title">Fecha</label><br>
          <input type="date" class="form-control" id="entrada" name="entrada" value="{{ old('entrada') }}"/>
            @error('entrada')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
        </div>

        <x-SelectTipoLavado select-tipo="{{old('tipo')}}" />

        <br>
        <button type="submit" class="btn btn-primary">Guardar</button>
  </form>

@endsection