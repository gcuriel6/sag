<?php

  session_start();
	include('../models/ServiciosOrdenes.php');

  $idOrdenServicio = $_REQUEST['id_orden_servicio'];

  $serviciosOrdenes = new ServiciosOrdenes();

    if (isset($_SESSION['usuario']))
        echo  $serviciosOrdenes->buscarVisitas($idOrdenServicio);
    else
        echo json_encode("sesion");
 	
?>