<?php
    session_start();
	include('../widgets/ExcelDashFinanzas.php');

    $modeloExcelDashFinanzas = new ExcelDashFinanzas();

    $nombre=$_REQUEST['i_nombre_excel'];
    $modulo=$_REQUEST['i_modulo_excel'];
    $fecha=$_REQUEST['i_fecha_excel'];
    $datos='';
    if(isset($_REQUEST['i_datos_excel'])){
        $datos=$_REQUEST['i_datos_excel'];
    }

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloExcelDashFinanzas->generaExcelDashFinanzas($nombre,$modulo,$fecha,$datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>