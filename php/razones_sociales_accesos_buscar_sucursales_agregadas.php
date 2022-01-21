<?php
    session_start();
	include('../models/RazonesSocialesAccesos.php');

    $idRazonSocial=$_REQUEST['idRazonSocial'];

    $modeloRazonesSocialesAccesos = new RazonesSocialesAccesos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRazonesSocialesAccesos->buscarSucursalesAgregadas($idRazonSocial);
    }else{
        echo json_encode("sesion");
    }
 	
?>