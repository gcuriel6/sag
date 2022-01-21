<?php
    session_start();
	include('../models/Firmantes.php');

    $datos=$_REQUEST['datos'];
 
    $modeloFirmantes = new Firmantes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFirmantes->AccesoSucursales('quitar',$datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>