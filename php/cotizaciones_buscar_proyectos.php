<?php
    session_start();
	include('../models/Cotizaciones.php');

	$idSucursal = $_REQUEST['idSucursal'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->buscarCotizacionesProyectos($idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>