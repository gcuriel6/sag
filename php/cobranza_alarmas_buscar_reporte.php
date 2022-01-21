<?php
    session_start();
	include('../models/CobranzaAlarmas.php');

    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];
    $idsSucursales = $_REQUEST['idsSucursales'];

    $modeloCobranza = new Cobranza();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCobranza->buscarCobranzaReporte($fechaInicio,$fechaFin,$idsSucursales);
    }else{
        echo json_encode("sesion");
    }
 	
?>