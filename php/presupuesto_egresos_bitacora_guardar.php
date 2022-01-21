<?php
    session_start();
	include('../models/PresupuestoEgresosBitacora.php');

    $datos = $_REQUEST['datos'];
   
    $modeloPresupuestoEgresosBitacora = new PresupuestoEgresosBitacora();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloPresupuestoEgresosBitacora->guardarPresupuestoEgresosBitacora($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>