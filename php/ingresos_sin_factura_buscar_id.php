<?php
    session_start();
	include('../models/IngresosSinFactura.php');

    $idIngreso=$_REQUEST['idIngreso'];

    $modeloIngresos = new IngresosSinFactura();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloIngresos->buscarIngresosSinFacturaId($idIngreso);
    }else{
        echo json_encode("sesion");
    }
 	
?>