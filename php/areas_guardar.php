<?php
    session_start();
	include('../models/Areas.php');

    $datos = $_REQUEST['datos'];
   
    $modeloAreas = new Areas();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloAreas->guardarAreas($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>