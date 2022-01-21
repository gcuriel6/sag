<?php

session_start();
include('../models/Facturacion.php');

$datos = $_REQUEST['datos'];

$modeloFacturacion = new Facturacion();

if (isset($_SESSION['usuario']))
    echo $modeloFacturacion->actualizarDatosCliente($datos);
else
    echo "sesion";

?>