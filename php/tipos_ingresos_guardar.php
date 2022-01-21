<?php
    session_start();
	include('../models/TiposIngresos.php');

    $datos = $_REQUEST['datos'];
   
    $modeloTiposIngresos = new TiposIngresos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloTiposIngresos->guardarTiposIngresos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>