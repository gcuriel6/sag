<?php
	include('../models/Preguntas.php');

    $estatus=$_REQUEST['estatus'];

    $modeloPreguntas = new Preguntas();

    echo $resultado = $modeloPreguntas->buscarPreguntas($estatus);
    
?>