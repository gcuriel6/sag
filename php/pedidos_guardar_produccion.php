<?php

    session_start();

	include('../models/Pedidos.php');

	$idPedido = $_REQUEST['id_pedido'];
    $seguimiento = $_REQUEST['seguimiento'];
    $productos = $_REQUEST['productos'];
    
    $modeloPedidos = new Pedidos();

//77    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloPedidos->guardarProduccion($idPedido, $seguimiento, $productos);
    //else
      //  echo json_encode("sesion");
 	
?>