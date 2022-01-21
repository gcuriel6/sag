<?php
    session_start();
	include('../models/ClasificacionGasto.php');

    $idClasificacionGasto=$_REQUEST['idClasificacionGasto'];

    $modeloClasificacionGasto = new ClasificacionGasto();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloClasificacionGasto->buscarClasificacionGastoId($idClasificacionGasto);
    }else{
        echo json_encode("sesion");
    }
 	
?>