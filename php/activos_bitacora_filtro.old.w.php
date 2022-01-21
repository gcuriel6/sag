<?php
    session_start();
	  include('../models/Activos.php');

    $no_serie = $_REQUEST['no_serie'];
    $tipo = $_REQUEST['tipo'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->buscarBitacoraFiltro($no_serie, $tipo);
    }else{
        echo json_encode("sesion");
    }

?>
