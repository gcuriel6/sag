<?php
    session_start();
	include('../models/Areas.php');

    $estatus=$_REQUEST['estatus'];

    $modeloUsuario = new Areas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarAreas($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>