<?php

    session_start();

	include('../models/Productos.php');

    $idUnidad = $_REQUEST['idUnidad'];
    $idSucursal = $_REQUEST['idSucursal'];
    $idFamilia = $_REQUEST['idFamilia'];
    $idLinea = $_REQUEST['idLinea'];
    $tipo = (isset($_REQUEST['tipo']) ? $_REQUEST['tipo'] : 0);

    $modelProductos = new Productos();

    if (isset($_SESSION['usuario']))
          echo $modelProductos->buscarProductosActivosTodos($idUnidad, $idSucursal, $idFamilia, $idLinea, $tipo);
    else
        echo json_encode("sesion");
 	
?>