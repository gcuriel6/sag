<?php
    session_start();
	include('../models/PresupuestoEgresosSeguimiento.php');
    
    $reporte = $_REQUEST['reporte'];
    $datos = $_REQUEST['datos'];

    $modeloPresupuestoEgresosSeguimiento= new PresupuestoEgresosSeguimiento();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloPresupuestoEgresosSeguimiento->obtieneTablaReporte($reporte,$datos);
    else
        echo json_encode("sesion");

   
?>