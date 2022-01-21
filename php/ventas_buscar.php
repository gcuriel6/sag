<?php
    session_start();
	include('../models/Ventas.php');

    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];
    $idCliente  = $_REQUEST['idCliente'];
    $cotizacion = $_REQUEST['cotizacion'];
    $idSucursal = $_REQUEST['idSucursal'];

    $modeloUsuario = new Ventas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarVentas($cotizacion,$fechaInicio,$fechaFin,$idCliente,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>