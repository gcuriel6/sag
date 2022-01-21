<?php
    session_start();
	include('../models/Tallas.php');

	$idDetalle = $_REQUEST['id_detalle'];
	$tipo = $_REQUEST['tipo'];
    $modeloTallas = new Tallas();
    if (isset($_SESSION['usuario']))
          echo $modeloTallas->obtenerTallasDetalle($idDetalle, $tipo);
    /*else
        echo json_encode("sesion");*/
 	
?>