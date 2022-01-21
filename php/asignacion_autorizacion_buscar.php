<?php
    session_start();

	include('../models/AsignacionAutorizacion.php');

    $estatus = $_REQUEST['estatus'];
    
    $modeloAsignacionAutorizacion = new AsignacionAutorizacion();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAsignacionAutorizacion->buscarAsignacionAutorizacion($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>