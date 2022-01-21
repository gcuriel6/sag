<?php
    
	include('../models/Encuesta.php');

    $datos=$_REQUEST['datos'];

    $modeloEncuesta = new Encuesta();

    echo $resultado = $modeloEncuesta->guardarRespuestaPregunta($datos);
 	
?>