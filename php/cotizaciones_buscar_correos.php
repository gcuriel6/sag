<?php
    session_start();
	include('../models/Cotizaciones.php');

    $idSucursal=$_REQUEST['idSucursal'];
    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->buscarCotizacionesCorreos($idUnidadNegocio,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>