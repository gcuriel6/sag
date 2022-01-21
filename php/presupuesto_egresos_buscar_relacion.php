<?php

session_start();
include("../models/PresupuestoEgresos.php");
$link = Conectarse();

$idPresupuesto = $_REQUEST['idPresupuesto'];

$presupuestoEgresos = new PresupuestoEgresos();

if (isset($_SESSION['usuario']))
      echo $presupuestoEgresos->buscarFactorProrrateo($idPresupuesto);
else
    echo json_encode("sesion");
		
?>