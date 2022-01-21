<?php
    session_start();
	include('../models/Uniformes.php');

    $datos = $_REQUEST['datos'];
   
    $modeloUniformes = new Uniformes();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloUniformes->guardarUniformes($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>