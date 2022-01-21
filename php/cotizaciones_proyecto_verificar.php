<?php
    session_start();
	include('../models/Cotizaciones.php');

    $nombreProyecto=$_REQUEST['nombreProyecto'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->verificarCotizacionesProyecto($nombreProyecto);
    }else{
        echo json_encode("sesion");
    }
 	
?>