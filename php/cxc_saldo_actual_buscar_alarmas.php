<?php
    session_start();
    include('../models/CxC.php');
    
    $idCxC = $_REQUEST['idCxC'];
    $tipo = $_REQUEST['tipo'];

    $modeloCxC = new CxC();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxC->buscarSaldoActualIdCxCAlarmas($idCxC,$tipo);
    }else{
        echo json_encode("sesion");
    }
 	
?>