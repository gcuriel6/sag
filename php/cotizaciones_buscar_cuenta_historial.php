<?php
    session_start();
    include('../models/Cotizaciones.php');
    
    $idCotiz=$_POST['idCotiz'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->buscarCotizacionesCuentaHistorial($idCotiz);
    }else{
        echo json_encode("sesion");
    }
 	
?>