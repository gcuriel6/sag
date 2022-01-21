<?php
    session_start();
	include('../models/PorcentajeUtilidad.php');

    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];
    $idSucursal=$_REQUEST['idSucursal'];

    $modeloPorcentajeUtilidad = new PorcentajeUtilidad();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloPorcentajeUtilidad->buscarPorcentajeUtilidadIdUnidad($idUnidadNegocio,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>