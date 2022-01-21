<?php

    session_start();
	include('../models/Pedidos.php');

    $datos = $_REQUEST['datos'];

    $modeloPedidos= new Pedidos();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloPedidos->guardarFacturacion($datos);
    else
        echo json_encode("sesion");
 	
?>