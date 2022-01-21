<?php
    session_start();
	include('../models/Accesos.php');

    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];
    $idUsuario=$_REQUEST['idUsuario'];

    $modeloAccesos = new Accesos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAccesos->buscarSucursalesConAcceso($idUnidadNegocio,$idUsuario);
    }else{
        echo json_encode("sesion");
    }
 	
?>