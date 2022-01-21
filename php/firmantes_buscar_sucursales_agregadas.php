<?php
    session_start();
	include('../models/Firmantes.php');

    $idFirmante=$_REQUEST['idFirmante'];

    $modeloFirmantes = new Firmantes();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFirmantes->buscarSucursalesAgregadas($idFirmante);
    }else{
        echo json_encode("sesion");
    }
 	
?>