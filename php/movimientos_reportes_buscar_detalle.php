<?php
    session_start();
	include('../models/MovimientosCuentas.php');

    $fechaInicio = isset($_REQUEST['fechaI']) ? $_REQUEST['fechaI'] : "";
    $fechaFin = isset($_REQUEST['fechaF'])  ? $_REQUEST['fechaF'] : "";
    $idCuenta = $_REQUEST['idCuenta'];

    $modeloMovimientosCuentas = new MovimientosCuentas();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloMovimientosCuentas->buscarMovimientosReporteDetalle($idCuenta, $fechaInicio, $fechaFin);
    }else{
        echo json_encode("sesion");
    }
 	
?>