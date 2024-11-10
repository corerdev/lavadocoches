<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <?php
     
    //Creamos el array de errores para luego, y hacemos el validar

    $erroresF = array();
    $dataF = validar();

    if(filter_input_array(INPUT_POST) && $dataF['valido'] == true) //Si tenemos un post y la comprobación local funciona, hacemos 
    // el curl
    {
        
        $ws = curl_init();
        
        curl_setopt_array($ws, array(
            CURLOPT_URL => "http://localhost/API/ejercicio6/public/api/citas/api",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($dataF), //al cual le mandamos el validar que hemos hecho
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json"
            ),
        ));
               
        $respuesta = curl_exec($ws);

        curl_close($ws);

        $array_respuesta= json_decode($respuesta, true);

        //Si el array de respuesta no viene vacio, y el campo que pusimos para comrpobar la validez es correcto, mostramos el ticket
          
        if(!empty($array_respuesta) && $array_respuesta['esValido']==true)
        {
            echo '<div class="ticketDiv">';
            echo '<p><strong>Nombre:</strong>'.$array_respuesta['datosTicket']['nombre'].' </p>';
            echo '<p><strong>Telefono:</strong> '.$array_respuesta['datosTicket']['telefono'].'</p>';
            echo '<p><strong>Coche:</strong> '.$array_respuesta['datosTicket']['coche'].'</p>';
            echo '<p><strong>Matricula:</strong> '.$array_respuesta['datosTicket']['matricula'].'</p>';
            echo '<p><strong>Tipo de lavado:</strong> '.$array_respuesta['datosTicket']['nombreLavado'].'</p>';
            if ($array_respuesta['datosTicket']['llantas'] == "1") {
            echo '<p><strong>Lavado de llantas:</strong> Si</p>';
            } else {
            echo '<p><strong>Lavado de llantas:</strong> No</p>';
            }
            echo '<p><strong>Tiempo de lavado:</strong> '.$array_respuesta['datosTicket']['tiempoLavado'].' minutos</p>';
            echo '<p><strong>Entrada:</strong> '.$array_respuesta['datosTicket']['entradaBonita'].'</p>';
            echo '<p><strong>Salida:</strong> '.$array_respuesta['datosTicket']['salidaBonita'].'</p>';
            echo '<p><strong>Coste total:</strong> '.$array_respuesta['datosTicket']['precio'].'€ </p>';
            echo '</div>';
        }
        else // Si no, cogemos el array de errores que nos viene junto a la validación y la asignamos
        {
            $erroresF = $array_respuesta['listaErrores'];
        }
    }

    // En caso de que tanto la validación local como la de servidor no sean válidas, mostramos el formulario.
    // Lo he hecho de esta manera ya que, al no poner que tenga que ser false, nos vale, a nivel local, para la primera vez
    // que cargamos la página (no puede ser true ya que no hay post) como para las siguientes, si el validar no es válido.
    // La parte de array_respuesta está por un motivo muy simple; a nivel local no compruebo que la fecha no sea anterior a la
    // actual, ya que me dió problemas, y se puede dar el caso de que se ponga esa fecha, la comprobación local sea válida pero la 
    // de servidor no, asi que nos aseguramos que ambas tienen que ser válidas para abandonar el formulario

    if (!$dataF['valido'] == true || !$array_respuesta['esValido']==true) {

    ?>
    
    <form action="api.php" method=post>

        <!-- ----------------           Label del nombre       ---------------- -->
                
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $dataF['nombre'];?>"/><br />
        <?php

        // En todos los formularios hacemos la parte de los errores por duplicado, una para la comprobación local y otra para
        // la de servidor

        if(isset($erroresF['nombre']) && !empty($erroresF['nombre']))
        {
            echo '<span class="rojo">'.$erroresF['nombre'][0].'</span><br/><br/>';
        }

        if(isset($dataF['errores']['nombre']) && !empty($dataF['errores']['nombre']))
        {
            echo '<span class="rojo">'.$dataF['errores']['nombre'].'</span><br/><br/>';
        }

        ?> 

        <!-- ----------------           Label del telefono       ---------------- -->

        <label>Telefono:</label>
        <input type="text" name="telefono" value="<?php echo $dataF['telefono'];?>"/><br />
        <?php


        if(isset($erroresF['telefono']) && !empty($erroresF['telefono']))
        {
            echo '<span class="rojo">'.$erroresF['telefono'][0].'</span><br/><br/>';
        }


        if(isset($dataF['errores']['telefono']) && !empty($dataF['errores']['telefono']))
        {
            echo '<span class="rojo">'.$dataF['errores']['telefono'].'</span><br/><br/><br/>';
            echo '<span class="rojo">'.$dataF['errores']['telefonoB'].'</span><br/><br/>';
        }


        ?>

        <!-- ----------------           Label del coche       ---------------- -->

        <label>Coche:</label>
        <input type="text" name="coche" value="<?php echo $dataF['coche'];?>"/><br />
        <?php

        if(isset($erroresF['coche']) && !empty($erroresF['coche']))
        {
            echo '<span class="rojo">'.$erroresF['coche'][0].'</span><br/><br/>';
        }

        if(isset($dataF['errores']['coche']) && !empty($dataF['errores']['coche']))
        {
            echo '<span class="rojo">'.$dataF['errores']['coche'].'</span><br/><br/>';
        }

        ?>
        <label>Matricula:</label>
        <input type="text" name="matricula" value="<?php echo $dataF['matricula'];?>"/><br />
        <?php

        if(isset($erroresF['matricula']) && !empty($erroresF['matricula']))
        {
            echo '<span class="rojo">'.$erroresF['matricula'][0].'</span><br/><br/>';
        }

        if(isset($dataF['errores']['matricula']) && !empty($dataF['errores']['matricula']))
        {
            echo '<span class="rojo">'.$dataF['errores']['matricula'].'</span><br/><br/>';
        }

        ?>

        <!-- ----------------           Label de la fecha       ---------------- -->

        <label>Introduzca fecha:</label>
        <input type="date" name="entrada" value="<?php echo $dataF['entrada'];?>"/><br />
        <?php

        if(isset($erroresF['entrada']) && !empty($erroresF['entrada']))
        {
            echo '<span class="rojo">'.$erroresF['entrada'][0].'</span><br/><br/>';
        }

        if(isset($dataF['errores']['fecha']) && !empty($dataF['errores']['fecha']))
        {
            echo '<span class="rojo">'.$dataF['errores']['fecha'].'</span><br/><br/>';
        }

        ?>

        <!-- ----------------           Label del lavado       ---------------- -->

        <label>Tipo de lavado:</label>
            <select name='tipo_lavado' >
                <option value="Ninguno"></option>

            <?php

                $conexion = new PDO('mysql:host=localhost;dbname=elefanteazul', "dwes", "1234");

                $consultaOpciones = $conexion->prepare("SELECT * FROM tipo_lavado");
                $consultaOpciones->execute();
                $registroLavados = $consultaOpciones->fetchAll();

                if(!empty($registroLavados))
                {
                            
                    foreach($registroLavados as $r)
                    {
                        echo '<option value="' .$r['descripcion'].'">' .$r['descripcion'].' ('.$r['precio'].'€)</option>';
                    };
                }

            ?>
            </select><br />
        <?php
        
        if(isset($erroresF['lavado']) && !empty($erroresF['lavado']))
        {
            echo '<br/><span class="rojo">'.$erroresF['lavado'][0].'</span><br/><br/>';
        } 

        if(isset($dataF['errores']['lavado']) && !empty($dataF['errores']['lavado']))
        {
            echo '<br/><span class="rojo">'.$dataF['errores']['lavado'].'</span><br/><br/>';
        }
        
        ?>

        <!-- ----------------           Label de las llantas       ---------------- -->

        <label>Limpieza de llantas (15€)</label>
        <input type="checkbox" name='llantas' /><br />
                
        <button type="submit">Enviar</button>
    </form>
              
    </hr>

    <?php } 

    // La parte de la validación es prácticamente igual que cuando haciamos el puro php, asi que no hay mucho a destacar aquí, 
    // aparte de algunos cambios de campo. 

function validar()
{
    $arrayValidacion=array();

    $arrayValidacion['valido'] = true;
    $arrayValidacion['errores'] = array();
    
    $arrayValidacion['nombre']='';
    $arrayValidacion['telefono']='';
    $arrayValidacion['coche']='';
    $arrayValidacion['matricula']='';
    $arrayValidacion['entrada']='';
    $arrayValidacion['tipo_lavado']='';
    $arrayValidacion['llantas']='';
    
    if(!filter_input_array(INPUT_POST))
    {
        $arrayValidacion['valido'] = false;
    }
    else
    {
        $arrayValidacion['nombre']=filter_input(INPUT_POST, 'nombre');
        $arrayValidacion['telefono']=filter_input(INPUT_POST, 'telefono');
        $arrayValidacion['coche']=filter_input(INPUT_POST, 'coche');
        $arrayValidacion['matricula']=filter_input(INPUT_POST, 'matricula');
        $arrayValidacion['entrada']=filter_input(INPUT_POST, 'entrada');
        $arrayValidacion['tipo_lavado']=filter_input(INPUT_POST, 'tipo_lavado');
        $arrayValidacion['llantas']=filter_input(INPUT_POST, 'llantas');
        $date = str_replace('-"', '/', $arrayValidacion['entrada']);  
        $newDate = date("d/m/Y", strtotime($date));  
        $arrayValidacion['entrada']= $newDate;

        $nombreER = '/^[A-Za-z]+$/';
        $telefonoER = '/^[679][0-9]{8}$/';
        $matriculaER = '/^[0-9]{4}[A-Za-z]{3}$/';
        $ahora = date('d/m/Y');
        $costeLlantas = 0;
        $costeLavado = 0;
         
        //Codigo que afecta al nombre
        if(empty($arrayValidacion['nombre']))
        {
            $arrayValidacion['valido'] = false;
            $arrayValidacion['errores']['nombre']='El nombre no puede estar vacío.';
        }else if (!preg_match($nombreER,  $arrayValidacion['nombre'])) {

            $arrayValidacion['valido'] = false;
            $arrayValidacion['errores']['nombre']='El nombre solo puede contener letras.';

        }
        //Codigo que afecta al telefono
        if(empty($arrayValidacion['telefono']))
        {
            $arrayValidacion['valido'] = false;
            $arrayValidacion['errores']['telefono']='El telefono no puede estar vacío.';
            $arrayValidacion['errores']['telefonoB']='Por favor introduzca un número de teléfono.';
        }else if (!preg_match($telefonoER,  $arrayValidacion['telefono'])) {

            $arrayValidacion['valido'] = false;
            $arrayValidacion['errores']['telefono']='El formato del telefono no es correcto.';
            $arrayValidacion['errores']['telefonoB']='Debe tener 9 números y empezar por 6, 7 o 9.';

        }
        //Codigo que afecta a la fecha
        if($arrayValidacion['entrada']=='01/01/1970')
        {
            $arrayValidacion['valido'] = false;
            $arrayValidacion['errores']['fecha']='La fecha no puede estar vacía.';
        }
        //Codigo que afecta al coche
        if(empty($arrayValidacion['coche']))
        {
            $arrayValidacion['valido'] = false;
            $arrayValidacion['errores']['coche']='El coche no puede estar vacío.';
        }
        //Codigo que afecta a la matricula
        if(empty($arrayValidacion['matricula']))
        {
            $arrayValidacion['valido'] = false;
            $arrayValidacion['errores']['matricula']='La matricula no puede estar vacía.';
            $arrayValidacion['errores']['matriculaB']='Por favor introduzca una matrícula.';
        }else if (!preg_match($matriculaER,  $arrayValidacion['matricula'])) {

            $arrayValidacion['valido'] = false;
            $arrayValidacion['errores']['matricula']='El formato de la matricula no es correcto.';
            $arrayValidacion['errores']['matriculaB']='El formato debe ser - 0000AAA.';

        }

        //Codigo que afecta al lavado
        if($arrayValidacion['tipo_lavado']=='Ninguno')
        {
            $arrayValidacion['valido'] = false;
            $arrayValidacion['errores']['lavado']='El lavado no puede estar vacío.';
        }

    }

    return $arrayValidacion;

}
      
?>  
        
    </body>
</html>
