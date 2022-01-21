<?php
    session_start();
	include('../models/Firmantes.php');

    $estatus=$_REQUEST['estatus'];

    $modeloFirmantes = new Firmantes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFirmantes->buscarFirmantes($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>