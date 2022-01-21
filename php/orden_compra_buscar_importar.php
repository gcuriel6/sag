<?php
    session_start();
	include('../models/OrdenCompra.php');

    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];
    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
    $idSucursal =$_REQUEST['idSucursal'];

    
    $modeloOrdenCompra = new OrdenCompra();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloOrdenCompra->buscarOrdenCompraImportar($idUnidadNegocio,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>