<?php
    session_start();
	include('../models/Activos.php');

    $noEconomico = $_REQUEST['noEconomico'];
    $tipo = $_REQUEST['tipo'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->buscarActivosFiltroE01($noEconomico, $tipo);
    }else{
        echo json_encode("sesion");
    }

?>