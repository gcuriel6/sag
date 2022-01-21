<?php
    session_start();
	include('../models/Accesos.php');

    $idUsuario=$_REQUEST['idUsuario'];

    $modeloAccesos = new Accesos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAccesos->buscarSucursalesAgregadas($idUsuario);
    }else{
        echo json_encode("sesion");
    }
 	
?>