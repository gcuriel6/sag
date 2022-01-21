<?php
    session_start();
    include('../models/CxP.php');
    
    $datos = $_REQUEST['datos'];

    $modeloCxP = new CxP();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxP->buscarFacturasCxP($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>