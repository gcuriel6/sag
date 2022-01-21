<?php
    session_start();
	  include('../models/Activos.php');

    $datos_generales = $_REQUEST['datos_generales'];
    $datos_armas = $_REQUEST['datos_armas'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->guardarActivoArmas($datos_generales, $datos_armas);
    }else{
        echo json_encode("sesion");
    }


?>
