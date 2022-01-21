<?php

    session_start();
	include('../models/Almacenes.php');

	$idUnidad = $_REQUEST['id_unidad'];
	$idSucursal = $_REQUEST['id_sucursal'];
    $idProducto = $_REQUEST['id_producto'];

    $idFamilia = $_REQUEST['id_familia'];
    $idLinea = $_REQUEST['id_linea'];
    
    $fechaDe = isset($_REQUEST['fecha_de']) ? $_REQUEST['fecha_de'] : '';
    $fechaA = isset($_REQUEST['fecha_a']) ? $_REQUEST['fecha_a'] : '';

    $concepto = '';

    $modeloAlmacen = new Almacenes();

    if (isset($_SESSION['usuario']))
    	echo $modeloAlmacen->reporteDetallado($idUnidad, $idSucursal, $idFamilia, $idLinea, $idProducto, $concepto, $fechaDe, $fechaA);
    else
        echo json_encode("sesion");
 	
?>