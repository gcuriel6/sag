<?php
    session_start();
    include('../models/Cotizaciones.php');
    
    $idCotizacion=$_REQUEST['idCotizacion'];
    $idProyecto = $_REQUEST['idProyecto'];
	$estatusProyecto = $_REQUEST['estatusProyecto'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->actualizaEstatus($idCotizacion,$idProyecto,$estatusProyecto);
    }else{
        echo json_encode("sesion");
    }
 	
?>