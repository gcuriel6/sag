<?php
    session_start();
	include('../models/Preguntas.php');

    $datos=$_REQUEST['datos'];

    $modeloPreguntas = new Preguntas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloPreguntas->guardarPregunta($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>