<?php

session_start();
include("../models/PresupuestoEgresos.php");
$link = Conectarse();

$presupuestoEgresos = new PresupuestoEgresos();

$idUsuario = $_REQUEST['idUsuario'];

if (isset($_SESSION['usuario']))
      echo $presupuestoEgresos->verificaUsuarioEliminarPresupuesto($idUsuario);
else
    echo json_encode("sesion");
		
?>