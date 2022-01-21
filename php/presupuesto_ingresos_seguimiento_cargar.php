<?php
    session_start();
	include('../models/PresupuestoIngresosSeguimiento.php');
    
    $reporte = $_REQUEST['reporte'];
    $datos = $_REQUEST['datos'];
  
    $modeloPresupuestoIngresosSeguimiento= new PresupuestoIngresosSeguimiento();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloPresupuestoIngresosSeguimiento->obtieneTablaReporte($reporte,$datos);
    else
        echo json_encode("sesion");

   
?>