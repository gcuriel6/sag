<?php
    session_start();
	include('../models/Firmantes.php');

    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];
    $idFirmante=$_REQUEST['idFirmante'];

    $modeloFirmantes = new Firmantes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFirmantes->buscarSucursalesDisponibles($idUnidadNegocio,$idFirmante);
    }else{
        echo json_encode("sesion");
    }
 	
?>