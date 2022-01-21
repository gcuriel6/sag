<?php

    session_start();
	include('../models/Almacenes.php');

    $idSucursal = $_REQUEST['id_sucursal'];
    $idProducto = $_REQUEST['id_producto'];
    $fechaDe = isset($_REQUEST['fecha_de']) ? $_REQUEST['fecha_de'] : '';
    $fechaA = isset($_REQUEST['fecha_a']) ? $_REQUEST['fecha_a'] : '';

    $modeloAlmacen = new Almacenes();

    if (isset($_SESSION['usuario']))
    	echo $modeloAlmacen->buscarRastreoRango($idSucursal, $idProducto, $fechaDe, $fechaA);
    else
        echo json_encode("sesion");
 	
?>