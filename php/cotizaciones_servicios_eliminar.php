<?php
    session_start();
	include('../models/CotizacionesSecciones.php');

    $idServicio = $_REQUEST['idServicio'];

    $modeloCotizacionesSecciones = new CotizacionesSecciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizacionesSecciones->eliminarServicios($idServicio);
    }else{
        echo json_encode("sesion");
    }
 	
?>