<?php
    session_start();
    include('../models/CxC.php');
    
    $idCliente = $_REQUEST['idCliente'];
    $tipo = $_REQUEST['tipo'];

    $fechaInicio = isset($_REQUEST['fechaInicio']) ? $_REQUEST['fechaInicio'] : '';
    $fechaFin = isset($_REQUEST['fechaFin']) ? $_REQUEST['fechaFin'] : '';

    $modeloCxC = new CxC();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxC->buscarEstadoCuenta($idCliente,$tipo,$fechaInicio,$fechaFin);
    }else{
        echo json_encode("sesion");
    }
 	
?>