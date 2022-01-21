<?php
    session_start();
	include('../models/ClasificacionGasto.php');

    $estatus=$_REQUEST['estatus'];

    $modeloClasificacionGasto = new ClasificacionGasto();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloClasificacionGasto->buscarClasificacionGasto($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>