<?php
    session_start();
	include('../models/Tallas.php');

    $estatus=$_REQUEST['estatus'];

    $modeloTallas = new Tallas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloTallas->obtenerListaTallas();
    }else{
        echo json_encode("sesion");
    }
 	
?>