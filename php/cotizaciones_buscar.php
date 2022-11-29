<?php
    session_start();
    include('../models/Cotizaciones.php');
    
    $fechaInicio=$_POST['fechaInicio'];
    $fechaFin=$_POST['fechaFin'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->buscarCotizaciones($fechaInicio, $fechaFin);
    }else{
        echo json_encode("sesion");
    }
 	
?>