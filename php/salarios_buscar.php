<?php
    session_start();
	include('../models/Salarios.php');

    $estatus=$_REQUEST['estatus'];
    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];
    $idSucursal=$_REQUEST['idSucursal'];

    $modeloUsuario = new Salarios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarSalarios($estatus,$idUnidadNegocio,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>