<?php
    session_start();
	include('../models/FamiliasGastos.php');

    $idFamiliaGasto=$_REQUEST['idFamiliaGasto'];

    $modeloFamiliasGastos = new FamiliasGastos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFamiliasGastos->buscarFamiliasGastosId($idFamiliaGasto);
    }else{
        echo json_encode("sesion");
    }
 	
?>