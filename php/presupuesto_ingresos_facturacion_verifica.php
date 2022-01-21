<?php

session_start();
include("../models/PresupuestoIngresosFacturacion.php");
$link = Conectarse();

$PresupuestoIngresosFacturacion = new PresupuestoIngresosFacturacion();
$idUnidad = $_REQUEST['id_unidad'];
$idSucursal =$_REQUEST['id_sucursal'];
$anio = $_REQUEST['anio'];
$mes = isset($_REQUEST['mes']) ? $_REQUEST['mes'] : 0;

if (isset($_SESSION['usuario']))
      echo $PresupuestoIngresosFacturacion->verificarSiHayInsercion($idUnidad, $idSucursal, $anio, $mes);
else
    echo json_encode("sesion");
		
?>