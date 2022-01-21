<?php
    session_start();
	include('../models/Clientes.php');

    $idCliente=$_REQUEST['idCliente'];

    $modeloCliente = new Clientes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCliente->buscarClientesId($idCliente);
    }else{
        echo json_encode("sesion");
    }
 	
?>