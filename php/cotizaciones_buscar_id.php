<?php
    session_start();
    include('../models/Cotizaciones.php');
    
    $idCotizacion=$_REQUEST['idCotizacion'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->buscarCotizacionesId($idCotizacion);
    }else{
        echo json_encode("sesion");
    }
 	
?>