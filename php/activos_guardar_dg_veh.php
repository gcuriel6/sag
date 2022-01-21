<?php
    session_start();
	  include('../models/Activos.php');

    $datos_generales = $_REQUEST['datos_generales'];
    $datos_vehiculo = $_REQUEST['datos_vehiculo'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->guardarActivoVehiculo($datos_generales, $datos_vehiculo);
    }else{
        echo json_encode("sesion");
    }


?>
