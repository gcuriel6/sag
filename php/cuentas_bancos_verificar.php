<?php
    session_start();

	include('../models/CuentasBancos.php');

    $cuenta = $_REQUEST['cuenta'];
    
    $modeloCuentasBancos = new CuentasBancos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCuentasBancos->verificarCuentasBancos($cuenta);
    }else{
        echo json_encode("sesion");
    }
 	
?>