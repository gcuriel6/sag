<?php
    session_start();
	  include('../models/Activos.php');

    $datos_generales = $_REQUEST['datos_generales'];
    $datos_celular = $_REQUEST['datos_celular'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->guardarActivoCelular($datos_generales, $datos_celular);
    }else{
        echo json_encode("sesion");
    }


?>
