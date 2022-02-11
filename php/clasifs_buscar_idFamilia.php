<?php
    session_start();
	include('../models/ClasificacionGasto.php');

    $idFamilia=$_REQUEST['idFamilia'];

    $modeloClasificaciones = new ClasificacionGasto();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloClasificaciones->buscarClasificacionesIdFamilia($idFamilia);
    }else{
        echo json_encode("sesion");
    }
 	
?>