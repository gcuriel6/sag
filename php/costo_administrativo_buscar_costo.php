<?php
    session_start();
	include('../models/CostoAdministrativo.php');

    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];
    $idSucursal=$_REQUEST['idSucursal'];

    $modeloCostoAdministrativo = new CostoAdministrativo();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCostoAdministrativo->buscarCostoAdministrativoCosto($idUnidadNegocio,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>