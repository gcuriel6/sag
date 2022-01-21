<?php
    session_start();

	include('../models/AsignacionAutorizacion.php');

    $idUsuario = $_REQUEST['idUsuario'];
    
    $modeloAsignacionAutorizacion = new AsignacionAutorizacion();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAsignacionAutorizacion->verificarAsignacionAutorizacion($idUsuario);
    }else{
        echo json_encode("sesion");
    }
 	
?>