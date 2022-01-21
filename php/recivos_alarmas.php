<?php
    session_start();
    include('../models/RecibosAlarmas.php');
    
    $datos = $_REQUEST['datos'];

    $modeloRecibosAlarmas = new RecibosAlarmas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRecibosAlarmas->buscarRecibosAlarmas($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>