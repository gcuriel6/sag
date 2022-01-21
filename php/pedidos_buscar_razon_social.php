<?php

    session_start();

	include('../models/Pedidos.php');
    $idRazonSocial =  $_REQUEST['id_razon_social'];


    
    $modeloPedidos = new Pedidos();

//77    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloPedidos->buscarPedidosFacturacion($idRazonSocial);
    //else
      //  echo json_encode("sesion");
 	
?>