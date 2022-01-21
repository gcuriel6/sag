<?php
    session_start();
	include('../models/ServiciosOrdenesSeguimiento.php');

    $idOrdenServicio=$_REQUEST['idOrdenServicio'];

    $modeloServiciosOrdenesSeguimiento = new ServiciosOrdenesSeguimiento();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloServiciosOrdenesSeguimiento->buscarServiciosOrdenesSeguimientoId($idOrdenServicio);
    }else{
        echo json_encode("sesion");
    }
 	
?>