<?php
    session_start();
	include('../models/Almacenes.php');

    $idSucursal = $_REQUEST['id_sucursal'];
    $idProducto = $_REQUEST['id_producto'];
    $fechaFin = isset($_REQUEST['fechaFin']) ? $_REQUEST['fechaFin'] : '';

    $modeloAlmacen = new Almacenes();

    if (isset($_SESSION['usuario']))
    	echo $modeloAlmacen->buscarExistenciaProductoRangoFechas($idSucursal, $idProducto, $fechaFin);
    else
        echo json_encode("sesion");
 	
?>