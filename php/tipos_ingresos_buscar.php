<?php
    session_start();
	include('../models/TiposIngresos.php');

    $estatus=$_REQUEST['estatus'];

    $modeloUsuario = new TiposIngresos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarTiposIngresos($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>