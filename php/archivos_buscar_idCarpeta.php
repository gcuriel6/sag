<?php
    session_start();
	include('../models/Archivos.php');

    $idCarpeta = $_REQUEST['idCarpeta'];
    $carpeta = $_REQUEST['carpeta'];
   
    $modeloArchivos = new Archivos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloArchivos->buscarArchivosIdCarpeta($idCarpeta,$carpeta);
    }else{
        echo json_encode("sesion");
    }
 	
?>