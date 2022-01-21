<?php
    session_start();
	include('../models/ClasificacionGasto.php');

    $datos = $_REQUEST['datos'];
   
    $modeloClasificacionGasto = new ClasificacionGasto();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloClasificacionGasto->guardarClasificacionGasto($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>