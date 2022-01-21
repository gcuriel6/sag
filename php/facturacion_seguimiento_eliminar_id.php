<?php
    session_start();
	include('../models/Facturacion.php');

    $idPartida = $_REQUEST['idPartida'];

    $modeloFacturacion = new Facturacion();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFacturacion->eliminarPartida($idPartida);
    }else{
        echo json_encode("sesion");
    }
 	
?>