<?php
    session_start();
	include('../models/Cotizaciones.php');

    $nombreCotizacion=$_REQUEST['nombreCotizacion'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->verificarCotizaciones($nombreCotizacion);
    }else{
        echo json_encode("sesion");
    }
 	
?>