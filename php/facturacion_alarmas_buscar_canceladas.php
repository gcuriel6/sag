<?php
    session_start();
    include('../models/FacturacionAlarmas.php');
    
    $datos = $_REQUEST['datos'];

    $modeloFacturacionAlarmas = new FacturacionAlarmas();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFacturacionAlarmas->buscarFacturasCanceladas($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>