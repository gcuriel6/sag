<?php

    session_start();

	include('../models/Pedidos.php');
    $idUnidad = $_REQUEST['id_unidad'];
    
    $modeloPedidos = new Pedidos();

//77    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloPedidos->buscarClientes($idUnidad);
    //else
      //  echo json_encode("sesion");
 	
?>