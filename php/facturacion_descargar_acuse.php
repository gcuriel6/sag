<?php

session_start();
include('../models/Facturacion.php');

$idFactura = $_REQUEST['idFactura'];
$idCFDI = $_REQUEST['idCFDI'];

$modeloFacturacion = new Facturacion();

if (isset($_SESSION['usuario']))
    echo $modeloFacturacion->descargarAcuse($idFactura,$idCFDI);
else
    echo "sesion";

?>