<?php
    session_start();
	include('../models/CostoAdministrativo.php');

    $datos = $_REQUEST['datos'];

    $modeloCostoAdministrativo = new CostoAdministrativo();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCostoAdministrativo->guardarCostosAdministrativos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>