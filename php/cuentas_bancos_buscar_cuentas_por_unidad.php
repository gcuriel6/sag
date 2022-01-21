<?php
    session_start();
	include('../models/CuentasBancos.php');

    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];

    $modeloCuentasBancos = new CuentasBancos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCuentasBancos->buscarCuentasBancosidUnidadNegocio($idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>