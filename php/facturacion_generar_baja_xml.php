<?php
    session_start();
    include('../models/Facturacion.php');
    
    $idFactura = $_REQUEST['id'];
    $folioFactura = $_REQUEST['folio'];
    $tipo = $_REQUEST['tipo'];

    $modeloFacturacion = new Facturacion();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloFacturacion->generarBajaXml($idFactura,$folioFactura,$tipo);
    else
        echo json_encode("sesion");
?>