<?php
    session_start();
	include('../models/Preguntas.php');

    $idPregunta=$_REQUEST['idPregunta'];

    $modeloPreguntas = new Preguntas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloPreguntas->buscarPreguntaId($idPregunta);
    }else{
        echo json_encode("sesion");
    }
 	
?>