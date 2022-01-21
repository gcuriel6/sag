<?php
    session_start();
	include('../models/Servicios.php');

    $modeloServicios = new Servicios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloServicios->buscarCuentaServicios();
    }else{
        echo json_encode("sesion");
    }
 	
?>