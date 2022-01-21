<?php
    session_start();

	include('../models/AsignacionAutorizacion.php');

    $datos = $_REQUEST['datos'];
    
    $modeloAsignacionAutorizacion = new AsignacionAutorizacion();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAsignacionAutorizacion->guardarAsignacionAutorizacion($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>