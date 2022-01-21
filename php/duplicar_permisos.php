<?php
    session_start();
	include('../models/Permisos.php');

    $origen = $_REQUEST['origen'];
    $destino = $_REQUEST["destino"];
   
    $modeloPermisos = new Permisos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloPermisos->duplicarPermisos($origen, $destino);
    }else{
        echo json_encode("sesion");
    }
 	
?>