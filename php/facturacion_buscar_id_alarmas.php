<?php
    session_start();
    include('../models/FacturacionAlarmas.php');
    
    $idFactura = $_REQUEST['idFactura'];

    $modeloFacturacionAlarmas = new FacturacionAlarmas();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFacturacionAlarmas->buscarFacturasIdAlarmas($idFactura);
    }else{
        echo json_encode("sesion");
    }
 	
?>