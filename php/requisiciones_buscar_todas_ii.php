<?php
    session_start();
	include('../models/Requisiciones.php');

    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
	$idUnidad = isset($_REQUEST['id_unidad']) ? $_REQUEST['id_unidad'] : null;
    $fechaDe = isset($_REQUEST['fecha_de']) ? $_REQUEST['fecha_de'] : null;
    $fechaA = isset($_REQUEST['fecha_a']) ? $_REQUEST['fecha_a'] : null;

    $modeloRequisiciones = new Requisiciones();

    if (isset($_SESSION['usuario']))
          echo $modeloRequisiciones->buscarRequisicionesTodas($id, $idUnidad, $fechaDe, $fechaA);
    else
        echo json_encode("sesion");
 	
?>