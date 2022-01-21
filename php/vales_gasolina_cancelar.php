<?php
    session_start();
    include('../models/ValesGasolina.php');
    
    $idRegistro = $_REQUEST['idRegistro'];
    $justificacion = $_REQUEST['justificacion'];

    $modeloValesGasolina = new ValesGasolina();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloValesGasolina->cancelarValesGasolina($idRegistro,$justificacion);
    }else{
        echo json_encode("sesion");
    }
 	
?>