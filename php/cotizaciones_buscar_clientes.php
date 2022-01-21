<?php
    session_start();
	include('../models/Cotizaciones.php');

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->buscarCotizacionesClientes();
    }else{
        echo json_encode("sesion");
    }
 	
?>