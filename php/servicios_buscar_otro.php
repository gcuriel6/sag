<?php
    session_start();
	include('../models/Servicios.php');

    $estatus = $_REQUEST['estatus'];
    $idSucursal = $_REQUEST['idSucursal'];

    $modeloCliente = new Servicios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCliente->buscarServiciosOtro($estatus,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>