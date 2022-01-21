<?php
    session_start();
	include('../models/RazonesSociales.php');

    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];
    $idSucursal=$_REQUEST['idSucursal'];

    $modeloCliente = new RazonesSociales();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCliente->buscarRazonesSocialesUnidadSucursal($idUnidadNegocio,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>