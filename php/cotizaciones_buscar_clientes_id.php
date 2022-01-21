<?php
    session_start();
    include('../models/Cotizaciones.php');
    
    $nombreCliente=$_REQUEST['nombreCliente'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->buscarCotizacionesClientesId($nombreCliente);
    }else{
        echo json_encode("sesion");
    }
 	
?>