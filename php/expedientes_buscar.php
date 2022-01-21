<?php
    session_start();
	include('../models/Expedientes.php');

    $idSucursal = $_REQUEST['idSucursal'];
    $idUsuario  = $_REQUEST['idUsuario'];

    $modeloExpedientes = new Expedientes();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloExpedientes->buscarExpedientes($idSucursal,$idUsuario);
    }else{
        echo json_encode("sesion");
    }
 	
?>