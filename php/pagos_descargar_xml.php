<?php

    session_start();
    include('../models/Pagos.php');

    $idPago = $_REQUEST['id'];
    $folioPago = $_REQUEST['folio'];

    $modelPagos = new Pagos();

    if (isset($_SESSION['usuario']))
        echo $modelPagos->descargarXML($idPago,$folioPago);
    else
        echo "sesion";

?>