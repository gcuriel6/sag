<?php
    session_start();
	include('../models/ServiciosOrdenesSeguimiento.php');

    $idsSucursales = $_REQUEST['idsSucursales'];
    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];

    $modeloServiciosOrdenesSeguimiento = new ServiciosOrdenesSeguimiento();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloServiciosOrdenesSeguimiento->buscarReporteSeguimiento($fechaInicio,$fechaFin,$idsSucursales);
    }else{
        echo json_encode("sesion");
    }
 	
?>