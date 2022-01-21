<?php

session_start();
include('../models/Pagos.php');

$id = $_REQUEST['id'];
$idCFDI = $_REQUEST['id_cfdi'];

$modeloPagos = new Pagos();

if (isset($_SESSION['usuario']))
    echo $modeloPagos->actualizarDatosCFDI($id,$idCFDI);
else
    echo "sesion";

?>