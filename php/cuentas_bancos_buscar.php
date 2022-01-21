<?php
    session_start();
	include('../models/CuentasBancos.php');

    $estatus=$_REQUEST['estatus'];

    $modeloUsuario = new CuentasBancos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarCuentasBancos($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>