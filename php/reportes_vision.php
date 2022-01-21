<?php

    session_start();
    include('../models/Pedidos.php');
    
    $reporte = $_REQUEST['reporte'];

    $pedidos = new Pedidos();

    if (isset($_SESSION['usuario']))
    {

    	if($reporte == 'pedidos_almacen')
        	echo $pedidos->buscarPedidosAlmacen();

        if($reporte == 'pedidos_real')
        	echo $pedidos->buscarPedidosReal();

        if($reporte == 'producto_t')
            echo $pedidos->buscarProductoTer();
    
    }
    else
        echo json_encode("sesion");
    
 	
?>