<?php
    session_start();
    include('../models/Motivos.php');
    
    $modeloMotivos = new Motivos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloMotivos->buscarMotivos();
    }else{
        echo json_encode("sesion");
    }
 	
?>