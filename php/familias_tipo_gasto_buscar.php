<?php
    session_start();
	include('../models/Familias.php');

    $modeloFamilias = new Familias();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFamilias->buscarFamiliasTipoGastos();
    }else{
        echo json_encode("sesion");
    }
 	
?>