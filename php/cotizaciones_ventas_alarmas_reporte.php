<?php
    session_start();
	include('../models/ReportesAlarmas.php');

    $datos = $_REQUEST['datos'];

    $modeloReportesAlarmas = new ReportesAlarmas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloReportesAlarmas->buscarReporte($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>