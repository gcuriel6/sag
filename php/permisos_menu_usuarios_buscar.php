<?php
    session_start();
	include('../models/Permisos.php');

    $modeloPermisos = new Permisos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloPermisos->buscarMenuUsuarios();
    }else{
        echo json_encode("sesion");
    }
 	
?>