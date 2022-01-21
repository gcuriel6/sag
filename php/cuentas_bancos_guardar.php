<?php
    session_start();
	include('../models/CuentasBancos.php');

    $datos = $_REQUEST['datos'];
   
    $modeloCuentasBancos = new CuentasBancos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCuentasBancos->guardarCuentasBancos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>