<?php
    session_start();
    include('../models/CxP.php');

    $modeloCxP = new CxP();
    
    $fechaDe = $_REQUEST['fechaDe'];
    $fechaA = $_REQUEST['fechaA'];

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxP->buscarReporteFacturas($fechaDe, $fechaA);
    }else{
        echo json_encode("sesion");
    }
 	
?>