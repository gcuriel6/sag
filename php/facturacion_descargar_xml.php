<?php

    session_start();
    include('../models/Facturacion.php');

    $idFactura = $_REQUEST['id'];
    $folioFactura = $_REQUEST['folio'];

    $modeloFacturacion = new Facturacion();

    if (isset($_SESSION['usuario']))
        echo $modeloFacturacion->descargarXML($idFactura,$folioFactura);
    else
        echo "sesion";

?>