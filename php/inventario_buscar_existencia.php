<?php
    session_start();
	include('../models/Almacenes.php');

    $idSucursal = $_REQUEST['id_sucursal'];
    $idProducto = $_REQUEST['id_producto'];
    $fecha = isset($_REQUEST['fecha']) ? $_REQUEST['fecha'] : '';

    $modeloAlmacen = new Almacenes();

    if (isset($_SESSION['usuario']))
    	echo $modeloAlmacen->buscarExistenciaProducto($idSucursal, $idProducto, $fecha);
    else
        echo json_encode("sesion");
 	
?>