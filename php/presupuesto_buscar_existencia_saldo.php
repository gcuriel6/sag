<?php
    session_start();
	include('../models/PresupuestoEgresos.php');

    $datos = $_REQUEST['datos'];
    
    $modeloPresupuestoEgresos = new PresupuestoEgresos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloPresupuestoEgresos->buscarExistenciaSaldo($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>