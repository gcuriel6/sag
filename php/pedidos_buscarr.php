<?php

    session_start();

	include('../models/Pedidos.php');
    $idPedido = isset($_REQUEST['id_pedido']) ? $_REQUEST['id_pedido'] : 0;


    
    $modeloPedidos = new Pedidos();

//77    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloPedidos->buscarPedidos($idPedido);
    //else
      //  echo json_encode("sesion");
 	
?>