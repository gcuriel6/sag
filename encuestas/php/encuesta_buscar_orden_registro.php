<?php
    
	include('../models/Encuesta.php');

    $id=$_REQUEST['id'];

    $modeloEncuesta = new Encuesta();

    echo $resultado = $modeloEncuesta->buscaEncuestaServicio($id);
 	
?>