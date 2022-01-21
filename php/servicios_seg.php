<?php

    session_start();
	include('../models/ServiciosOrdenes.php');

    $params = array();
    $params['servicios.id_sucursal'] = $_REQUEST['id_sucursal'];

    $serviciosOrdenes = new ServiciosOrdenes();

    if (isset($_SESSION['usuario']))
        echo $test = $serviciosOrdenes->buscarServiciosOrdenesP($params);
    else
        echo json_encode("sesion");
 	
?>