<?php
    session_start();
	include('../models/FamiliasGastos.php');

    $estatus=$_REQUEST['estatus'];

    $modeloFamiliasGastos = new FamiliasGastos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFamiliasGastos->buscarFamiliasGastos($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>