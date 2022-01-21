<?php
    session_start();
	include('../models/Clientes.php');

    $estatus=$_REQUEST['estatus'];

    $modeloCliente = new Clientes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCliente->buscarClientes($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>