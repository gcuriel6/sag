<?php
    session_start();
    include('../models/CxP.php');
    
    $tipo = $_REQUEST['tipo'];
    $idRegistro = $_REQUEST['idRegistro'];
    $idUsuario = $_REQUEST['idUsuario'];
    $justificacion = $_REQUEST['justificacion'];

    $modeloCxP = new CxP();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxP->cancelarCxP($tipo,$idRegistro,$idUsuario,$justificacion);
    }else{
        echo json_encode("sesion");
    }
 	
?>