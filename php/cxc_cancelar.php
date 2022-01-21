<?php
    session_start();
    include('../models/CxC.php');
    
    $idCXC = $_REQUEST['idCXC'];
    $tipo = $_REQUEST['tipo'];
    //-->NJES March/27/2020 se solicita que se justifique la cancelación de un cxc o una partida del cxc
    $justificacion = $_REQUEST['justificacion'];
    $idUsuario = $_REQUEST['idUsuario'];

    $modeloCxC = new CxC();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxC->cancelarCxC($idCXC,$tipo,$idUsuario,$justificacion);
    }else{
        echo json_encode("sesion");
    }
 	
?>