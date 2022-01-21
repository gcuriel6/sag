<?php
    session_start();

	include('../models/Activos.php');

    $numeroEconomico = $_REQUEST['numeroEconomico'];
    
    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloActivos->verificarNumeroEconomico($numeroEconomico);
    }else{
        echo json_encode("sesion");
    }
 	
?>