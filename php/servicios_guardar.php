<?php
    session_start();
	include('../models/Servicios.php');

    $datos = $_REQUEST['datos'];

    $modeloServicios = new Servicios();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloServicios->guardarServicios($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>