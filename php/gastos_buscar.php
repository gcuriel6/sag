<?php
    session_start();
	include('../models/Gastos.php');
    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
    $idSucursal = $_REQUEST['idSucursal'];
    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];

    $modeloGastos = new Gastos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloGastos->buscarGastos($idUnidadNegocio,$idSucursal,$fechaInicio,$fechaFin);
    }else{
        echo json_encode("sesion");
    }
 	
?>