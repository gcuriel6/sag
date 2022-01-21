<?php
    session_start();
	include('../models/CotizacionesSecciones.php');

    $idServicio = $_REQUEST['idServicio'];

    $modeloCotizacionesSecciones = new CotizacionesSecciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizacionesSecciones->buscarServiciosId($idServicio);
    }else{
        echo json_encode("sesion");
    }
 	
?>