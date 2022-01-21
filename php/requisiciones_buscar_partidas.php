<?php
    session_start();
    include('../models/Requisiciones.php');
    
 	$idRequisicion = $_REQUEST['idRequisicion'];	

    $modeloRequisiciones= new Requisiciones();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRequisiciones->buscarRequisicionPartidas($idRequisicion);
    }else{
        echo json_encode("sesion");
    }
 	
?>