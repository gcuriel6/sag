<?php
    session_start();

	include('../models/TiposIngresos.php');

    $descripcion = $_REQUEST['descripcion'];
    
    $modeloTiposIngresos = new TiposIngresos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloTiposIngresos->verificarTiposIngresos($descripcion);
    }else{
        echo json_encode("sesion");
    }
 	
?>