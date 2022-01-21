<?php
    session_start();
	include('../models/EntradasCompra.php');

    $datos = $_REQUEST['datos'];
    
    $modeloEntradasCompra = new EntradasCompra();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloEntradasCompra->buscarEntradasCompra($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>