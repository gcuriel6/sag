<?php
    session_start();
    include('../models/OrdenCompra.php');

    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];
    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
    $idSucursal =$_REQUEST['idSucursal'];
    $buscarTodo = (isset($_REQUEST['buscarTodo'])!='')?$_REQUEST['buscarTodo']:'';


    
    $modeloOrdenCompra = new OrdenCompra();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloOrdenCompra->buscarOrdenCompra($fechaInicio,$fechaFin,$idUnidadNegocio,$idSucursal,$buscarTodo);
    }else{
        echo json_encode("sesion");
    }
    
?>