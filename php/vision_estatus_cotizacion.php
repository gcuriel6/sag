<?php

    session_start();

    if (isset($_SESSION['usuario'])){

        include('../models/Vision.php');

        $modeloVision = new Vision();

        echo $resultado = $modeloVision->cambiarVisionCotizacionEstatus($_POST);
        
    }else{
        echo json_encode("sesion");
    }
 	
?>