<?php
    session_start();
	include('../models/Sucursales.php');

    $idSucursal=$_REQUEST['idSucursal'];

    $modeloSucursales = new Sucursales();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloSucursales->buscarSucursalesId($idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>