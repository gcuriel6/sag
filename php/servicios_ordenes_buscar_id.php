<?php
    session_start();
	include('../models/ServiciosOrdenes.php');

    $idOrdenServicio=$_REQUEST['idOrdenServicio'];

    $modeloServiciosOrdenes = new ServiciosOrdenes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloServiciosOrdenes->buscarServiciosOrdenesId($idOrdenServicio);
    }else{
        echo json_encode("sesion");
    }
 	
?>