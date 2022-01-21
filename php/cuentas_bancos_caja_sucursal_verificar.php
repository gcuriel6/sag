<?php
    session_start();

	include('../models/CuentasBancos.php');

    $idSucursal = $_REQUEST['idSucursal'];
    
    $modeloCuentasBancos = new CuentasBancos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCuentasBancos->verificarCuentaCajaChicaSucursal($idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>