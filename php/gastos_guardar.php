<?php
    session_start();
	include('../models/Gastos.php');

    $datos = $_REQUEST['datos'];
   
    $modeloGastos = new Gastos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloGastos->guardarGastos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>