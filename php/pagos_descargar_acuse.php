<?php

session_start();
include('../models/Pagos.php');

$idPago = $_REQUEST['idPago'];
$idCFDI = $_REQUEST['idCFDI'];

$modeloPagos = new Pagos();

if (isset($_SESSION['usuario']))
    echo $modeloPagos->descargarAcuse($idPago,$idCFDI);
else
    echo "sesion";

?>