<?php
    session_start();
	  include('../models/Activos.php');

    $datos_generales = $_REQUEST['datos_generales'];
    $datos_vehiculo = $_REQUEST['datos_vehiculo'];
    $id = $_REQUEST['id'];
    $id_veh = $_REQUEST['id_veh'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->actualizarActivoVehiculo($datos_generales, $datos_vehiculo, $id, $id_veh);
    }else{
        echo json_encode("sesion");
    }


?>
