<?php
    session_start();
	include('../models/Facturacion.php');

    $idCliente = $_REQUEST['idCliente'];

    $modeloFacturacion = new Facturacion();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFacturacion->buscarSeguimientoPartidas($idCliente);
    }else{
        echo json_encode("sesion");
    }
 	
?>