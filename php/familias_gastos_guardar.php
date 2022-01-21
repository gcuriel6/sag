<?php
    session_start();
	include('../models/FamiliasGastos.php');

    $datos = $_REQUEST['datos'];
   
    $modeloFamiliasGastos = new FamiliasGastos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFamiliasGastos->guardarFamiliasGastos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>