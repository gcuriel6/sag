<?php
    session_start();
	include('../models/CuentasBancos.php');

    $idCuentaBanco=$_REQUEST['idCuentaBanco'];

    $modeloUsuario = new CuentasBancos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarCuentasBancosId($idCuentaBanco);
    }else{
        echo json_encode("sesion");
    }
 	
?>