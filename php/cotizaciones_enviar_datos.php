<?php
    session_start();
	include('../models/Cotizaciones.php');

    $datos = $_REQUEST['datos'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizaciones->enviarDatosCotizacion($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>