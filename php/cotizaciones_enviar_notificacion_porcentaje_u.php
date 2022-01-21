<?php
    session_start();
	include('../models/Cotizaciones.php');

    $idCotizacion = $_REQUEST['idCotizacion'];
    $utilidad = $_REQUEST['utilidad'];
    $porcentajeUtilidad = $_REQUEST['porcentajeUtilidad'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizaciones->enviarNotificacionPorcentajeUtilidad($idCotizacion,$utilidad,$porcentajeUtilidad);
    }else{
        echo json_encode("sesion");
    }
 	
?>