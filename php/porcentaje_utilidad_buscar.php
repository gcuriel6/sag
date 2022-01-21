<?php
    session_start();
	include('../models/PorcentajeUtilidad.php');

    $estatus=$_REQUEST['estatus'];
    $lista=$_REQUEST['lista'];

    $modeloPorcentajeUtilidad = new PorcentajeUtilidad();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloPorcentajeUtilidad->buscarPorcentajeUtilidad($estatus,$lista);
    }else{
        echo json_encode("sesion");
    }
 	
?>