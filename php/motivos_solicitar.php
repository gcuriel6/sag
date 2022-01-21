<?php
    session_start();
	include('../models/Motivos.php');

    $datos = $_REQUEST['datos_importe'];
    $idSucursal = $_REQUEST['idSucursal'];
    //$idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
    $sucursal = $_REQUEST['sucursal'];
    //$unidad = $_REQUEST['unidad'];

    $modeloMotivos = new Motivos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloMotivos->solicitarMotivos($datos,$idSucursal,$sucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>