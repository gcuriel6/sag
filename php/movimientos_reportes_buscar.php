<?php
    session_start();
	include('../models/MovimientosCuentas.php');

    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];
    $idCuenta = isset($_REQUEST['idCuenta']) ? $_REQUEST['idCuenta'] : '';
    $saldosCuentas = (isset($_REQUEST['saldosCuentas'])!='')?$_REQUEST['saldosCuentas']:'';

    $modeloMovimientosCuentas = new MovimientosCuentas();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloMovimientosCuentas->buscarMovimientosReporte($fechaInicio,$fechaFin,$idCuenta,$saldosCuentas);
    }else{
        echo json_encode("sesion");
    }
 	
?>