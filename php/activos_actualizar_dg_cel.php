<?php
    session_start();
	  include('../models/Activos.php');

    $datos_generales = $_REQUEST['datos_generales'];
    $datos_celular = $_REQUEST['datos_celular'];
    $id = $_REQUEST['id'];
    $id_cel = $_REQUEST['id_cel'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->actualizarActivoCelular($datos_generales, $datos_celular, $id, $id_cel);
    }else{
        echo json_encode("sesion");
    }


?>
