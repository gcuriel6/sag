<?php

session_start();
include("../models/PresupuestoOtrosIngresos.php");
$link = Conectarse();

$PresupuestoOtrosIngresos = new PresupuestoOtrosIngresos();
$idUnidad = $_REQUEST['id_unidad'];
$idSucursal =$_REQUEST['id_sucursal'];
$anio = $_REQUEST['anio'];
$mes = isset($_REQUEST['mes']) ? $_REQUEST['mes'] : 0;
$idDepartamento = $_REQUEST['idDepartamento'];
$idArea = $_REQUEST['idArea'];

if (isset($_SESSION['usuario']))
      echo $PresupuestoOtrosIngresos->buscaInformacionPresupuesto($idUnidad, $idSucursal, $anio, $mes, $idDepartamento, $idArea);
else
    echo json_encode("sesion");
		
?>