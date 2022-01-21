<?php

    session_start();
	include('../models/ServiciosOrdenes.php');

    $latitud = $_REQUEST['latitud'];
   	$longitud = $_REQUEST['longitud'];		
   	$location = $_REQUEST['location'];
   	$idOrdenServicio = $_REQUEST['id_orden_servicio'];
    $idUsuario = $_SESSION['id_usuario'];
    $observaciones = $_REQUEST['observaciones'];


    $serviciosOrdenes = new ServiciosOrdenes();

    if (isset($_SESSION['usuario']))
        echo  $serviciosOrdenes->guardarVisita($idOrdenServicio, $latitud, $longitud, $location, $idUsuario,$observaciones);
    else
        echo json_encode("sesion");
 	
?>