<?php
    session_start();
	include('../models/Firmantes.php');

    $nombre = $_REQUEST['nombre'];

    $modeloFirmantes = new Firmantes();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFirmantes->verificarFirmantes($nombre);
    }else{
        echo json_encode("sesion");
    }
 	
?>