<?php
    session_start();
	include('../models/IngresosSinFactura.php');

    $fechaInicio=$_REQUEST['fechaInicio'];
    $fechaFin=$_REQUEST['fechaFin'];

    $modeloUsuario = new IngresosSinFactura();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarIngresosSinFactura($fechaInicio,$fechaFin);
    }else{
        echo json_encode("sesion");
    }
 	
?>