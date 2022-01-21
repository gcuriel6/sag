<?php
    session_start();
	include('../models/ServiciosOrdenesSeguimiento.php');

    $semana = $_REQUEST['semana'];
    $idSucursal = $_REQUEST['idSucursal'];

    $modeloServiciosOrdenesSeguimiento = new ServiciosOrdenesSeguimiento();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloServiciosOrdenesSeguimiento->buscarServiciosOrdenesSeguimiento($semana,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>