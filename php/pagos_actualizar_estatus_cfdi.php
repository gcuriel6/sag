<?php

session_start();
include('../models/Pagos.php');

$id = $_REQUEST['id'];
$estatus = $_REQUEST['estatus'];

$modeloPagos = new Pagos();

if (isset($_SESSION['usuario']))
    echo $modeloPagos->actualizarEstatusPago($id,$estatus);
else
    echo "sesion";

?>