<?php
    session_start();
	include('../models/Familias.php');

    $estatus=$_REQUEST['estatus'];

    $modeloFamilias = new Familias();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFamilias->buscarFamilias($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>