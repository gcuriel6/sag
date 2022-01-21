<?php
    session_start();

	include('../models/CxC.php');

    $idCxC = $_REQUEST['idCxC'];
    
    $modeloCxC = new CxC();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxC->buscaNumCxCMismaFactura($idCxC);
    }else{
        echo json_encode("sesion");
    }
 	
?>