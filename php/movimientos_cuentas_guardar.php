<?php
    session_start();
	include('../models/MovimientosCuentas.php');

    $datos = $_REQUEST['datos'];

    $modeloMovimientosCuentas = new MovimientosCuentas();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloMovimientosCuentas->guardarMovimientosCuentas($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>