<?php
    session_start();
	include('../models/Viaticos.php');
    $datos = $_REQUEST['datos'];
    $idsSucursal = $datos['idsSucursal'];
    $fechaInicio = $datos['fechaInicio'];
    $fechaFin = $datos['fechaFin'];
   
    $modeloViaticos = new Viaticos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloViaticos->buscarReporteViaticos($idsSucursal,$fechaInicio,$fechaFin);
    }else{
        echo json_encode("sesion");
    }
 	
?>