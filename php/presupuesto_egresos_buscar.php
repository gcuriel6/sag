<?php

session_start();
include("../models/PresupuestoEgresos.php");
$link = Conectarse();

$presupuestoEgresos = new PresupuestoEgresos();

$idUnidadNegocio = isset($_REQUEST['id_unidad_negocio']) ? $_REQUEST['id_unidad_negocio'] : 0;
$anio = $_REQUEST['anio'];
$mes = isset($_REQUEST['mes']) ? $_REQUEST['mes'] : 0;

if (isset($_SESSION['usuario']))
      echo $presupuestoEgresos->buscar($anio, $mes,$idUnidadNegocio);
else
    echo json_encode("sesion");
		
?>