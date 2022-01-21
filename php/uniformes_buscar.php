<?php
    session_start();
	include('../models/Uniformes.php');

    $estatus=$_REQUEST['estatus'];

    $modeloUsuario = new Uniformes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarUniformes($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>