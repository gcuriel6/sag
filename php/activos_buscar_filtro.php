<?php
    session_start();
	  include('../models/Activos.php');

    $no_serie = $_REQUEST['no_serie'];
    $fecha = $_REQUEST['fecha'];
    $empresa = $_REQUEST['empresa'];
    $tipo = $_REQUEST['tipo'];
    $f = $_REQUEST['f'];
    $no_economico = $_REQUEST['no_economico'];
    $datos = $_REQUEST['datos'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->buscarActivosFiltro($datos,$no_serie, $fecha, $empresa, $tipo, $f, $no_economico);
    }else{
        echo json_encode("sesion");
    }

?>
