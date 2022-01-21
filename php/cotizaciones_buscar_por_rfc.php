<?php
    session_start();
    include('../models/Cotizaciones.php');
    
    $rfc=$_REQUEST['rfc'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->buscarCotizacionesPorRfc($rfc);
    }else{
        echo json_encode("sesion");
    }
 	
?>