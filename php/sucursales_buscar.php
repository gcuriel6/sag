<?php
    session_start();
	include('../models/Sucursales.php');

    $estatus=$_REQUEST['estatus'];
    $lista=$_REQUEST['lista'];

    $modeloSucursales = new Sucursales();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloSucursales->buscarSucursales($estatus,$lista);
    }else{
        echo json_encode("sesion");
    }
 	
?>