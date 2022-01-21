<?php
    session_start();
	include('../models/Contratos.php');

    $idCliente=$_REQUEST['idCliente'];

    $modeloUsuario = new Contratos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarContratosIdCliente($idCliente);
    }else{
        echo json_encode("sesion");
    }
 	
?>