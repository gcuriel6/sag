<?php
    session_start();

	include('../models/AsignacionAutorizacion.php');

    $id = $_REQUEST['id'];
    
    $modeloAsignacionAutorizacion = new AsignacionAutorizacion();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAsignacionAutorizacion->buscarAsignacionAutorizacionId($id);
    }else{
        echo json_encode("sesion");
    }
 	
?>