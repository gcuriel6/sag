<?php
    session_start();
	include('../models/Cotizaciones.php');

    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->buscarCotizacionesPlantillas($idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>