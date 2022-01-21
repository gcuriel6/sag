<?php

    session_start();

	include('../models/Pedidos.php');
    $data = $_REQUEST['data'];
    
    $modeloPedidos = new Pedidos();

//77    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloPedidos->guardarPedidos($data);
    //else
      //  echo json_encode("sesion");
 	
?>