<?php
    session_start();
	include('../models/Archivos.php');

    $idArea=$_REQUEST['idArea'];
    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];

    $modeloArchivos = new Archivos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloArchivos->buscarArchivosIdArea($idUnidadNegocio,$idArea);
    }else{
        echo json_encode("sesion");
    }
 	
?>