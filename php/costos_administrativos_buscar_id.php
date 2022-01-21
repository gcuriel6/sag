<?php
    session_start();
	include('../models/CostoAdministrativo.php');

    $idCostoAdministrativo=$_REQUEST['idCostoAdministrativo'];

    $modeloCostoAdministrativo = new CostoAdministrativo();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCostoAdministrativo->buscarCostoAdministrativoId($idCostoAdministrativo);
    }else{
        echo json_encode("sesion");
    }
 	
?>