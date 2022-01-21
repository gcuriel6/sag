<?php
    session_start();
	include('../models/PorcentajeUtilidad.php');

    $id_unidad_negocio = $_REQUEST['id_unidad_negocio'];
    $id_sucursal = $_REQUEST['id_sucursal'];

    $modeloPorcentajeUtilidad = new PorcentajeUtilidad();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloPorcentajeUtilidad->verificarPorcentajeUtilidad($id_unidad_negocio,$id_sucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>