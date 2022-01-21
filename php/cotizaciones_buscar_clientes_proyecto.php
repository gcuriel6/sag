<?php
    session_start();
	include('../models/Cotizaciones.php');

	$idProyecto = $_REQUEST['idProyecto'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->buscarCotizacionesClientesProyecto($idProyecto);
    }else{
        echo json_encode("sesion");
    }
 	
?>