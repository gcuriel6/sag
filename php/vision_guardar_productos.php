<?php

    session_start();

    if (isset($_SESSION['usuario'])){

        include('../models/Vision.php');

        $modeloVision = new Vision();

        $arreglo = $_POST["arreglo"];

        echo $resultado = $modeloVision->guardarVisionProductos($arreglo);
        
    }else{
        echo json_encode("sesion");
    }
 	
?>