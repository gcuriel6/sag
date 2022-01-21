<?php
    session_start();
    include('../models/ValesGasolina.php');
    
    $idVale = $_REQUEST['idVale'];

    $modeloValesGasolina = new ValesGasolina();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloValesGasolina->buscarValesGasolinaId($idVale);
    }else{
        echo json_encode("sesion");
    }
 	
?>