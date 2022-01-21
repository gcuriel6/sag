<?php

    session_start();

	include('../models/Pedidos.php');
    $idPedido = $_REQUEST['id_pedido'];


    
    $modeloPedidos = new Pedidos();

//77    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloPedidos->buscarDetalles($idPedido);
    //else
      //  echo json_encode("sesion");
 	
?>