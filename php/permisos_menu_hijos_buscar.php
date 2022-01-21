<?php
    session_start();
	include('../models/Permisos.php');

    $padre=$_REQUEST['padre'];

    $modeloPermisos = new Permisos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloPermisos->buscarMenuHijos($padre);
    }else{
        echo json_encode("sesion");
    }
 	
?>