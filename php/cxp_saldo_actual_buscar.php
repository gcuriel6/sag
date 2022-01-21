<?php
    session_start();
    include('../models/CxP.php');
    
    $idCxP = $_REQUEST['idCxP'];

    $modeloCxP = new CxP();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxP->buscarSaldoActualIdCxP($idCxP);
    }else{
        echo json_encode("sesion");
    }
 	
?>