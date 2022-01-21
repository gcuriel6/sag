<?php
    session_start();
	include('../models/ServiciosOrdenes.php');

    $idServicio=$_REQUEST['idServicio'];

    $modeloServiciosOrdenes = new ServiciosOrdenes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloServiciosOrdenes->buscarServiciosOrdenesIdServicio($idServicio);
    }else{
        echo json_encode("sesion");
    }
 	
?>