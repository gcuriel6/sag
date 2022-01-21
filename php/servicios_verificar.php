<?php
    session_start();

	include('../models/Servicios.php');

    $cuenta = $_REQUEST['cuenta'];
    
    $modeloServicios = new Servicios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloServicios->verificarServicios($cuenta);
    }else{
        echo json_encode("sesion");
    }
 	
?>