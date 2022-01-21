<?php
    session_start();
	  include('../models/Activos.php');

    $datos_generales = $_REQUEST['datos_generales'];
    $datos_eq = $_REQUEST['datos_eq'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->guardarActivoEq($datos_generales, $datos_eq);
    }else{
        echo json_encode("sesion");
    }


?>
