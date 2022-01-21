<?php
    session_start();
	include('../models/ServiciosOrdenes.php');

    $idsSucursales = $_REQUEST['idsSucursales'];
    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];

    $modeloServiciosOrdenes = new ServiciosOrdenes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloServiciosOrdenes->buscarReporteServiciosOrdenes($fechaInicio,$fechaFin,$idsSucursales);
    }else{
        echo json_encode("sesion");
    }
 	
?>