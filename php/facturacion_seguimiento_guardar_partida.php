<?php
    session_start();
	include('../models/Facturacion.php');

    $datos = $_REQUEST['datos'];

    $modeloFacturacion = new Facturacion();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFacturacion->guardarSeguimientoPartidas($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>