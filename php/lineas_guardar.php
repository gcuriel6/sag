<?php
    session_start();
	include('../models/Lineas.php');

    $datos = $_REQUEST['datos'];
   
    $modeloLineas = new Lineas();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloLineas->guardarLineas($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>