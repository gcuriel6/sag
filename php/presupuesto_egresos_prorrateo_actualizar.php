<?php

session_start();
include("../models/PresupuestoEgresos.php");
$link = Conectarse();

$idProrrateo = $_REQUEST['idProrrateo'];
$montoP = $_REQUEST['montoP'];
$montos = $_REQUEST['montos'];

$presupuestoEgresos = new PresupuestoEgresos();

if (isset($_SESSION['usuario']))
      echo $presupuestoEgresos->actualizarFactorProrrateo($idProrrateo,$montoP,$montos);
else
    echo json_encode("sesion");
		
?>