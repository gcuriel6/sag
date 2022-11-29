<?php
    session_start();
	include('../models/MovimientosCuentas.php');

    $modeloMovimientosCuentas = new MovimientosCuentas();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloMovimientosCuentas->buscarCuentasBanco();
    }else{
        echo json_encode("sesion");
    }
 	
?>