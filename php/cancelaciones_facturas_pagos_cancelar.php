<?php
    session_start();
    include('../models/Facturacion.php');
    
    $folioFiscal = $_REQUEST['folioFiscal'];
    $idRegistro = $_REQUEST['idRegistro'];
    $tipo = $_REQUEST['tipo'];
    $rfcEmisor = $_REQUEST['rfcEmisor'];
    $rfcReceptor = $_REQUEST['rfcReceptor'];

    $modeloFacturacion = new Facturacion();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFacturacion->cancelarFacturaPagoConXmlAcuse($folioFiscal,$idRegistro,$tipo,$rfcEmisor,$rfcReceptor);
    }else{
        echo json_encode("sesion");
    }
?>