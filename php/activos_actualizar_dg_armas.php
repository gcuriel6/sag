<?php
    session_start();
	  include('../models/Activos.php');

    $datos_generales = $_REQUEST['datos_generales'];
    $datos_armas = $_REQUEST['datos_armas'];
    $idActivo = $_REQUEST['id'];
    $id_armas = $_REQUEST['id_armas'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->actualizarActivoArmas($datos_generales, $datos_armas, $idActivo, $id_armas);
    }else{
        echo json_encode("sesion");
    }


?>
