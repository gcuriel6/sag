<?php

    $prospecto = $_POST["prospecto"];
    $materias = $_POST["materias"];
    $productos = $_POST["productos"];        

    session_start();

    if (isset($_SESSION['usuario'])){

        include('../models/Vision.php');

        $modeloVision = new Vision();

        echo $resultado = $modeloVision->guardarVisionCotizacion($prospecto, $materias, $productos);
        
    }else{
        echo json_encode("sesion");
    }
 	
?>