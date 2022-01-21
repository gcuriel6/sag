<?php
    session_start();
	include('../models/ServiciosOrdenes.php');

    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];
    $idSucursal = $_REQUEST['idSucursal'];

    $modeloServiciosOrdenes = new ServiciosOrdenes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloServiciosOrdenes->buscarServiciosOrdenes($fechaInicio,$fechaFin,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>