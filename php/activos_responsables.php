<?php
    session_start();
	  include('../models/Activos.php');

    $id = $_REQUEST['id'];
    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->activosResponsables($id,$fechaInicio,$fechaFin);
    }else{
        echo json_encode("sesion");
    }

?>
