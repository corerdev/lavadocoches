@extends("layouts.basico")

@section('title','Lista de usuarios')

@section('scripts')

<script>

//Damos forma a la tabla con los parámetros que elijamos

$(document).ready(function () {
    var table = $('#listLavado').DataTable({
        "paging": true,
        "pagingType": "numbers",
        "lengthChange": true,
        "lengthMenu": [[5, 10, 100], [5, 10, 100]], //ponemos la longitud de las páginas a nuestro gusto
        "order": [[ 1, "asc" ]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('tipoLavado.getListado') }}",
            "type": "POST",
            "data": {"_token": "{{ csrf_token() }}"}
        },
        "columns": [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },
            { //Hacemos solo la descripción sea buscable u ordenable
                data: 'descripcion',
                name: 'descripcion'
            },
            {
                data: 'precio',
                name: 'precio',
                orderable: false,
                searchable: false
            },
            {
                data: 'tiempo',
                name: 'tiempo',
                orderable: false,
                searchable: false
            
            },
            {
                data: null,
                name: 'eliminar',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {                    
                    return '<input type="button" data-row="'+ meta.row +'" value="Eliminar" />'
                },
            }
        ],
        language: {
            "decimal":        ",",
            "emptyTable":     "No hay datos en la tabla",
            "info":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty":      "",
            "infoFiltered":   "",
            "infoPostFix":    "",
            "thousands":      ".",
            "lengthMenu":     "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "zeroRecords":    "No han encontrado registros",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Click/return para ordenar ascendentemente",
                "sortDescending": ": Click/return para ordenar descendentemente"
            }
        }
    });


    $('#listLavado tbody').on( 'click', 'tr input[value="Eliminar"]', function () {
        var confirmacion = window.confirm('Va a eliminar este tipo de lavado. ¿Desea continuar?')
        
        var dataRow=$(this).attr('data-row')
        var row = table.data()[dataRow];

        if(confirmacion) {
            $.ajax({ //llevamos a la función que elimina el lavado, pero solo si se confirma
                url: "{{ route('tipoLavado.eliminarLavado') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    idLavado: row.id
                },
                success: function(response){//Y una vez eliminado, actualizamos la tabla
                    table.ajax.reload();
                },
                error: function (response) {//por si hay un error, mostramos mensaje; esto puede ocurrir si hay citas con el
                //lavado que queriamos borrar, por ejemplo
                    console.error("Error", response);
                    window.alert("Ha ocurrido un problema en el servidor.");
                }
            });
        }

        
    });
});
    
</script>

@endsection

@section('contenido')

    <div>

        <h2>Lavados registrados</h2>

        <table id="listLavado">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Tiempo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                
            <tbody>        
        </table>   
    </div>

@endsection