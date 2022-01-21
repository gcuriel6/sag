<?php
    session_start();
	include('../models/RazonesSociales.php');

    $idRazonSocial=$_REQUEST['idRazonSocial'];

    $modeloCliente = new RazonesSociales();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCliente->buscarRazonesSocialesId($idRazonSocial);
    }else{
        echo json_encode("sesion");
    }
 	
?>