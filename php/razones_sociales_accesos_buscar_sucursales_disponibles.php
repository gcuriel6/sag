<?php
    session_start();
	include('../models/RazonesSocialesAccesos.php');

    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];
    $idRazonSocial=$_REQUEST['idRazonSocial'];

    $modeloRazonesSocialesAccesos = new RazonesSocialesAccesos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRazonesSocialesAccesos->buscarSucursalesDisponibles($idUnidadNegocio,$idRazonSocial);
    }else{
        echo json_encode("sesion");
    }
 	
?>