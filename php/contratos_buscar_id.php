<?php
    session_start();
	include('../models/Contratos.php');

    $idContrato=$_REQUEST['idContrato'];

    $modeloUsuario = new Contratos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarContratosId($idContrato);
    }else{
        echo json_encode("sesion");
    }
 	
?>