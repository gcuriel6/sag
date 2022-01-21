<?php

    $idCotiz = $_POST["idCotiz"];
    $productos = $_POST["productos"];        

    session_start();

    if (isset($_SESSION['usuario'])){

        include('../models/Vision.php');

        $modeloVision = new Vision();

        echo $resultado = $modeloVision->editarVisionCotizacion($idCotiz, $productos);
        
    }else{
        echo json_encode("sesion");
    }
 	
?>