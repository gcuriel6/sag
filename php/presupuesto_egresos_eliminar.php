<?php

session_start();
include("../models/PresupuestoEgresos.php");
$link = Conectarse();

$presupuestoEgresos = new PresupuestoEgresos();

$anio = $_REQUEST['anio'];
$mes = $_REQUEST['mes'];

if (isset($_SESSION['usuario']))
      echo $presupuestoEgresos->eliminarPresupuestoEgresos($anio, $mes);
else
    echo json_encode("sesion");
		
?>