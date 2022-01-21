<?php

    session_start();
	include('../models/ServiciosOrdenes.php');

    $latitud = $_REQUEST['latitud'];
   	$longitud = $_REQUEST['longitud'];		
   	$location = $_REQUEST['location'];
    $obs = $_REQUEST['obs'];
   	$idVisita = $_REQUEST['id_visita'];


    $serviciosOrdenes = new ServiciosOrdenes();

    if (isset($_SESSION['usuario']))
        echo  $serviciosOrdenes->cerrarVisita($idVisita, $latitud, $longitud, $location, $obs);
    else
        echo json_encode("sesion");
 	
?>