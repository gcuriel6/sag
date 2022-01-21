<?php
    session_start();
	include('../models/SalidasAlmacen.php');

    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
    $idSucursal =$_REQUEST['idSucursal'];
    $tipo =$_REQUEST['tipo'];

    
    $modeloSalidasAlmacen = new SalidasAlmacen();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloSalidasAlmacen->buscarSalidasImportar($idUnidadNegocio,$idSucursal,$tipo);
        
    }else{
        echo json_encode("sesion");
    }
 	
?>