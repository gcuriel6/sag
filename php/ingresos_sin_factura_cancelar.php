<?php
    session_start();

	include('../models/IngresosSinFactura.php');

    $datos = $_REQUEST['datos'];
    
    $modeloIngresosSinFactura = new IngresosSinFactura();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloIngresosSinFactura->verificarIngresosSinFactura($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>