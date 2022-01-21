<?php
    session_start();
	include('../models/Archivos.php');

    $datos=$_REQUEST['datos'];
    
    $modeloArchivos = new Archivos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloArchivos->eliminarCarpeta($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>