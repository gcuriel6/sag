<?php
    session_start();
	include('../models/CostoAdministrativo.php');

    $id_unidad_negocio = $_REQUEST['id_unidad_negocio'];
    $id_sucursal = $_REQUEST['id_sucursal'];

    $modeloCostoAdministrativo = new CostoAdministrativo();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCostoAdministrativo->verificarCostoAdministrativo($id_unidad_negocio,$id_sucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>