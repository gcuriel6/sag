<?php
    session_start();
	include('../models/Firmantes.php');

    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];
    $idSucursal=$_REQUEST['idSucursal'];

    $modeloFirmantes = new Firmantes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFirmantes->buscarFirmantesUnidadSucursal($idUnidadNegocio,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>