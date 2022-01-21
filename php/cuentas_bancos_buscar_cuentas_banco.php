<?php
    session_start();
	include('../models/CuentasBancos.php');

    $idBanco=$_REQUEST['idBanco'];

    $modeloUsuario = new CuentasBancos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarCuentasBancosidBanco($idBanco);
    }else{
        echo json_encode("sesion");
    }
 	
?>