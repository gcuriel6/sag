<?php
    session_start();
    include('../models/ValesGasolina.php');
    
    $datos = $_REQUEST['datos'];

    $modeloValesGasolina = new ValesGasolina();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloValesGasolina->buscarValesGasolinaReporte($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>