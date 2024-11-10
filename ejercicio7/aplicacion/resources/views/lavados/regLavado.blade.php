@extends("layouts.basico")

@section('title','Reservar cita')

@section('scripts')
@endsection

@section('contenido')
<script> //hacemos las funciones de las validaciones, las cuales cogen por ajax y pasan a la funcion que le indicamos en ruta
// el contenido de su respectivo campo. Si la respuesta viene con errores, escondemos el campo que indica que la descripcion es
// valida, y mostramos el de invalida con el mensaje. Si no es el caso, hacemos la inversa
        function validarDescripcion(){
            $.ajax({
                url: "{{ route('tipoLavado.validarDescripcion') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    descripcion: $('#descripcion').val(),
                },
                success: function(response){
                    
                    if (response.errors != null) {
                    $('#descripcionErrorSpan').text(response.errors[0]);
                    $('#descripcionValido').hide();
                    $('#descripcionErrorSpan').parent().show()
                    }
                    else{
                    $('#descripcionErrorSpan').text("");
                    $('#descripcionErrorSpan').parent().hide()
                    $('#descripcionValido').show();
                    }
                },
                error: function (response) {
                    console.error("Error", response);
                    window.alert("Ha ocurrido un problema en el servidor.");
                }
            });
        };

        function validarPrecio(){
            $.ajax({
                url: "{{ route('tipoLavado.validarPrecio') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    precio: $('#precio').val(),
                },
                success: function(response){
                    
                    if (response.errors != null) {
                    $('#precioErrorSpan').text(response.errors[0]);
                    $('#precioValido').hide();
                    $('#precioErrorSpan').parent().show()
                    }
                    else{
                    $('#precioErrorSpan').text("");
                    $('#precioErrorSpan').parent().hide()
                    $('#precioValido').show();
                    }
                },
                error: function (response) {
                    console.error("Error", response);
                    window.alert("Ha ocurrido un problema en el servidor.");
                }
            });
        };

        function validarTiempo(){
            $.ajax({
                url: "{{ route('tipoLavado.validarTiempo') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    tiempo: $('#tiempo').val(),
                },
                success: function(response){
                    
                    if (response.errors != null) {
                    $('#tiempoErrorSpan').text(response.errors[0]);
                    $('#tiempoValido').hide();
                    $('#tiempoErrorSpan').parent().show()
                    }
                    else{
                    $('#tiempoErrorSpan').text("");
                    $('#tiempoErrorSpan').parent().hide()
                    $('#tiempoValido').show();
                    }
                },
                error: function (response) {
                    console.error("Error", response);
                    window.alert("Ha ocurrido un problema en el servidor.");
                }
            });
        }; 
        //En el caso de la de registrar lavado, mandamos todos los campos a su funcion por route. Si viene algun error, lo mostramos;
        // Si no, mostramos un mensaje de success, ya que el lavado se ha registrado en la ruta
        function registrarLavado() {
            $.ajax({
                url: "{{ route('tipoLavado.registrarLavado') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    descripcion: $('#descripcion').val(),
                    tiempo: $('#tiempo').val(),
                    precio: $('#precio').val(),
                },
                success: function(response){

                    if (response.errors != null) {
                    if (response.errors.descripcion != null) {
                        $('#descripcionErrorSpan').text(response.errors.descripcion[0]);
                        $('#descripcionValido').hide();
                        $('#descripcionErrorSpan').parent().show()
                    }
                    if (response.errors.precio != null) {
                        $('#precioErrorSpan').text(response.errors.precio[0]);
                        $('#precioValido').hide();
                        $('#precioErrorSpan').parent().show()
                    }
                    if (response.errors.tiempo != null) {
                        $('#tiempoErrorSpan').text(response.errors.tiempo[0]);
                        $('#tiempoValido').hide();
                        $('#tiempoErrorSpan').parent().show()
                    }
                    }
                    else{
                    window.alert(response.success);
                    }
                },
                error: function (response) {
                    console.log("Error", response);
                    window.alert("Ha ocurrido un problema en el servidor.");
                }
            });
        }; 

</script>

<div>
            <div>
                <label for="descripcion" >Descripción</label>
                <input type="text" id="descripcion">
                <input type="button" onclick="validarDescripcion()" value="Validar"><br>
                <div id="descripcionValido" class="valido">Válido</div>
                <div class="invalido">
                    Error: <span id="descripcionErrorSpan"></span>
                </div>
            </div>
            <br>
            <div>
                <label for="precio" >Precio</label>
                <input type="text" id="precio">
                <input type="button" onclick="validarPrecio()" value="Validar"><br>
                <div id="precioValido" class="valido">Válido</div>
                <div class="invalido">
                    Error: <span id="precioErrorSpan"></span>
                </div>
            </div>
            <br>
            <div >
                <label for="tiempo">Tiempo</label>
                <input type="text" id="tiempo">
                <input type="button" onclick="validarTiempo()" value="Validar"><br>
                <span id="tiempoValido" class="valido">Válido</span>
                <div class="invalido">
                    Error: <span id="tiempoErrorSpan"></span>
                </div>
            </div>
            <br>
            <input type="button" value="Registrar" onclick="registrarLavado()"/> 

    </div>

@endsection