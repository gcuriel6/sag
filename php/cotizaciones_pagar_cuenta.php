<?php
    session_start();
    include('../models/Cotizaciones.php');
    
    $idCotiz=$_POST['idCotiz'];
    $importe=$_POST['importe'];
    $forma=$_POST['forma'];
    $tipo=$_POST['tipo'];
    $cuenta=$_POST['cuenta'];
    $referencia=$_POST['referencia'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->pagarCotizacionesCuenta($idCotiz, $importe, $forma, $tipo, $cuenta, $referencia);
    }else{
        echo json_encode("sesion");
    }
 	
?>