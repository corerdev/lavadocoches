@extends("layouts.basico")

@section('title','Reservar cita')

@section('contenido')



<form action="{{ route('usuarios.authenticate') }}" method="POST">
<h2>Login</h2>
@csrf
    <div class="row">
        <div>
            <div>
                <strong>Usuario:</strong>
                <input type="text" name="username" class="form-control" placeholder="Usuario" value="{{ old('username') }}">
                @error('username')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div>
            <div>
                <strong>Contraseña:</strong>
                <input type="password" name="password" class="form-control" placeholder="Contraseña" value="{{ old('password') }}">
                @error('password')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div>
            <div class="form-group">
                <br/>
                <button class='botonLogin' type="submit">Login</button>
            </div>
        <div>
            <button><a id="loginGoogle" href="{{ route('google.redirect') }}" class="btn btn-primary"> Login con Google </a></button>
        </div>
        </div>
    </div>
</form>

<hr>
        

@endsection