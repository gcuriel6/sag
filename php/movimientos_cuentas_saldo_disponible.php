<?php
    session_start();
	include('../models/MovimientosCuentas.php');

    $idCuentaBanco = $_REQUEST['idCuentaBanco'];

    $modeloMovimientosCuentas = new MovimientosCuentas();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloMovimientosCuentas->buscarSaldoDisponibleCuenta($idCuentaBanco);
    }else{
        echo json_encode("sesion");
    }
 	
?>