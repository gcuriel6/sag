<?php
    session_start();
    include('../models/CxP.php');
    
    $modeloCxP = new CxP();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxP->buscarReporteSaldosProveedores();
    }else{
        echo json_encode("sesion");
    }
 	
?>