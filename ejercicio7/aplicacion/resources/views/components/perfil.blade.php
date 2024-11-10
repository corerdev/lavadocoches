@if($log)

    <div class='divMenu'>
        <a href={{ route('citas.index') }}>Saludos, {{$nombre}} </a>
    </div>
    <div class='divMenu'>
        <a href={{ route('tipoLavado.regLavado') }}>Registrar tipo de lavado</a>
    </div>
    <div class='divMenu'>
        <a href={{ route('tipoLavado.listLavado') }}>Control de lavados</a>
    </div>
    <div class='divMenu'>
        <a href={{ route('usuarios.logout') }}>Cerrar sesión</a>
    </div>

@else

    <div class='divMenu'>
        <a href={{ route('usuarios.login') }}>Identifícate</a>
    </div>

@endif