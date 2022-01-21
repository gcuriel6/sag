<?php
    session_start();
	include('../models/Sucursales.php');

    $clave=$_REQUEST['clave'];

    $modeloSucursales = new Sucursales();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloSucursales->verificarSucursales($clave);
    }else{
        echo json_encode("sesion");
    }
 	
?>