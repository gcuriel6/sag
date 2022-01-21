<?php
    session_start();
	include('../models/Servicios.php');

    $idServicio = $_REQUEST['idServicio'];

    $modeloServicios = new Servicios();

    if (isset($_SESSION['usuario'])){
          echo $resultado = $modeloServicios->buscarServiciosSaldosPendientes($idServicio);
    }else{
        echo json_encode("sesion");
    }
 	
?>