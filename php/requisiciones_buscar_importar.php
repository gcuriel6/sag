<?php
    session_start();
	include('../models/Requisiciones.php');

    $idUnidad = $_REQUEST['idUnidad'];
    $idSucursal = $_REQUEST['idSucursal'];
    $idProveedor = $_REQUEST['idProveedor'];
    $tipo = $_REQUEST['tipo'];

    $modeloRequisiciones = new Requisiciones();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRequisiciones->buscarRequisicionesImportar($idUnidad, $idSucursal, $idProveedor, $tipo);
    }else{
        echo json_encode("sesion");
    }
 	
?>