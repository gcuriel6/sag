<?php
    session_start();
	include('../models/PresupuestoEgresosBitacora.php');

    $modulo = $_REQUEST['modulo'];
    $idUnidad = $_REQUEST['idUnidad'];
    $idSucursal = $_REQUEST['idSucursal'];
    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];
    
    $modeloPresupuestoEgresosBitacora = new PresupuestoEgresosBitacora();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloPresupuestoEgresosBitacora->buscarPresupuestoEgresosBitacora($modulo,$idUnidad,$idSucursal,$fechaInicio,$fechaFin);
    }else{
        echo json_encode("sesion");
    }
 	
?>