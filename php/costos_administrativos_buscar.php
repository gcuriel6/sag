<?php
    session_start();
	include('../models/CostoAdministrativo.php');

    $estatus=$_REQUEST['estatus'];
    $lista=$_REQUEST['lista'];

    $modeloCostoAdministrativo = new CostoAdministrativo();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCostoAdministrativo->buscarCostoAdministrativo($estatus,$lista);
    }else{
        echo json_encode("sesion");
    }
 	
?>