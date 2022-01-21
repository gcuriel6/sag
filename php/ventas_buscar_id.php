<?php
    session_start();
	include('../models/Ventas.php');

    $idVenta=$_REQUEST['idVenta'];
    $idSucursal = $_REQUEST['idSucursal'];
    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];

    $modeloUsuario = new Ventas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarVentasId($idVenta,$idSucursal,$idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>