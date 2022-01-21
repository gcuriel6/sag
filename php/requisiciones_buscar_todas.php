<?php
    session_start();
    include('../models/Requisiciones.php');
    
    $mantenimiento = isset($_REQUEST['mantenimiento']) ? $_REQUEST['mantenimiento'] : 0;
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    $idUnidad = isset($_REQUEST['idUnidadNegocio']) ? $_REQUEST['idUnidadNegocio'] : null;
    $idSucursal = isset($_REQUEST['idSucursal']) ? $_REQUEST['idSucursal'] : null;
    $fechaDe = isset($_REQUEST['fecha_de']) ? $_REQUEST['fecha_de'] : null;
    $fechaA = isset($_REQUEST['fecha_a']) ? $_REQUEST['fecha_a'] : null;

    $modeloRequisiciones = new Requisiciones();

    if (isset($_SESSION['usuario'])){

          echo $modeloRequisiciones->buscarRequisicionesTodas($mantenimiento,$id, $idUnidad, $idSucursal, $fechaDe, $fechaA);
    }else{
        echo json_encode("sesion");
    }
 	
?>