<?php
    session_start();
    include('../models/Pagos.php');
    
    $iPago = $_REQUEST['id'];
    $folioPago = $_REQUEST['folio'];
    $tipo = $_REQUEST['tipo'];

    $modelPagos = new Pagos();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modelPagos->generarBajaXml($iPago,$folioPago,$tipo);
    else
        echo json_encode("sesion");
?>