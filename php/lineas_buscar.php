<?php
    session_start();
	include('../models/Lineas.php');

    $estatus=$_REQUEST['estatus'];

    $modeloUsuario = new Lineas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarLineas($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>