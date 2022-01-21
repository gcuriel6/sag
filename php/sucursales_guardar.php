<?php
    session_start();
	include('../models/Sucursales.php');

    $datos = $_REQUEST['datos'];

    $modeloSucursales = new Sucursales();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloSucursales->guardarSucursales($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>