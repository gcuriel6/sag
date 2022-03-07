<?php
    session_start();
	include('../models/MovimientosCuentas.php');

    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];

    $modeloMovimientosCuentas = new MovimientosCuentas();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloMovimientosCuentas->buscarMovimientosReporteTodos($fechaInicio,$fechaFin);
    }else{
        echo json_encode("sesion");
    }
 	
?>