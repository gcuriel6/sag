<?php
    session_start();
	include('../models/Firmantes.php');

    $datos=$_REQUEST['datos'];

    $modeloFirmantes = new Firmantes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFirmantes->AccesoSucursales('agregar',$datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>