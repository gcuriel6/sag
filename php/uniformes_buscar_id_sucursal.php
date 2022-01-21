<?php
    session_start();
	include('../models/Uniformes.php');

    $idSucursal=$_REQUEST['idSucursal'];

    $modeloUniforme = new Uniformes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUniforme->buscarUniformesIdSucursal($idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>