<?php
    session_start();
	  include('../models/Activos.php');

    $unidad = $_REQUEST['unidad'];
    $idActivo = $_REQUEST['idActivo'];
    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->responsablesFiltro($unidad, $idActivo, $fechaInicio, $fechaFin);
    }else{
        echo json_encode("sesion");
    }

?>
