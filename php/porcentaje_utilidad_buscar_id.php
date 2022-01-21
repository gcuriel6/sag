<?php
    session_start();
	include('../models/PorcentajeUtilidad.php');

    $idPorcentajeUtilidad=$_REQUEST['idPorcentajeUtilidad'];

    $modeloPorcentajeUtilidad = new PorcentajeUtilidad();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloPorcentajeUtilidad->buscarPorcentajeUtilidadId($idPorcentajeUtilidad);
    }else{
        echo json_encode("sesion");
    }
 	
?>