<?php

session_start();
include("../models/PresupuestoIngresosSinCotizacion.php");
$link = Conectarse();

$PresupuestoIngresosSinCotizacion = new PresupuestoIngresosSinCotizacion();
$idUnidad = $_REQUEST['id_unidad'];
$idSucursal =$_REQUEST['id_sucursal'];
$anio = $_REQUEST['anio'];
$mes = isset($_REQUEST['mes']) ? $_REQUEST['mes'] : 0;
$tipo = $_REQUEST['tipo'];

if (isset($_SESSION['usuario']))
      echo $PresupuestoIngresosSinCotizacion->buscaInformacionPresupuesto($idUnidad, $idSucursal, $anio, $mes, $tipo);
else
    echo json_encode("sesion");
		
?>