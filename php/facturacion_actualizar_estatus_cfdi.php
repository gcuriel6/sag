<?php

session_start();
include('../models/Facturacion.php');

$id = $_REQUEST['id'];
$estatus = $_REQUEST['estatus'];

$modeloFacturacion = new Facturacion();

if (isset($_SESSION['usuario']))
    echo $modeloFacturacion->actualizarEstatusFactura($id,$estatus);
else
    echo "sesion";

?>