<?php
    session_start();
	  include('../models/Activos.php');

    $datos_generales = $_REQUEST['datos_generales'];
    $datos_eq = $_REQUEST['datos_eq'];
    $id = $_REQUEST['id'];
    $id_eq = $_REQUEST['id_eq'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->actualizarActivoEq($datos_generales, $datos_eq, $id, $id_eq);
    }else{
        echo json_encode("sesion");
    }


?>
