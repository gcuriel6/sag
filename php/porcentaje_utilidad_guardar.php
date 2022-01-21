<?php
    session_start();
	include('../models/PorcentajeUtilidad.php');

    $datos = $_REQUEST['datos'];

    $modeloPorcentajeUtilidad = new PorcentajeUtilidad();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloPorcentajeUtilidad->guardarPorcentajeUtilidad($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>