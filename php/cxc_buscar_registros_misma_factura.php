<?php
    session_start();
    include('../models/CxC.php');
    
    $idFactura = $_REQUEST['idFactura'];

    $modeloCxC = new CxC();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxC->buscarRegistroCxCMismaFactura($idFactura);
    }else{
        echo json_encode("sesion");
    }
 	
?>