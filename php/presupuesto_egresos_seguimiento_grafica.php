<?php
    session_start();
	include('../models/PresupuestoEgresosSeguimiento.php');
    
    $reporte = $_REQUEST['reporte'];
    $datos = $_REQUEST['datos'];

    if($reporte==""){
        return json_encode([]);
    }

    $modeloPresupuestoEgresosSeguimiento= new PresupuestoEgresosSeguimiento();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloPresupuestoEgresosSeguimiento->obtieneGraficaReporte($reporte,$datos);
    else
        echo json_encode("sesion");

   
?>