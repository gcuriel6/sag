<?php
    session_start();
	include('../models/Archivos.php');

    $datos=$_REQUEST['datos'];
    
    $modeloArchivos = new Archivos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloArchivos->guardar($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>