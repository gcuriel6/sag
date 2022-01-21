<?php
    session_start();
    include('../models/Facturacion.php');
    
    $idFactura = $_REQUEST['idFactura'];

    $modeloFacturacion = new Facturacion();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFacturacion->buscarSaldoFacturaIdMultipleCxC($idFactura);
    }else{
        echo json_encode("sesion");
    }
 	
?>