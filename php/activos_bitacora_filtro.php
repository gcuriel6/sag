<?php
    session_start();
	  include('../models/Activos.php');

    $no_economico = $_REQUEST['no_economico'];
    $tipo = $_REQUEST['tipo'];
    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->buscarBitacoraFiltro($no_economico, $tipo,$fechaInicio,$fechaFin);
    }else{
        echo json_encode("sesion");
    }

?>
