<?php
    session_start();
	include('../models/CotizacionesSecciones.php');

    $idCotizacion = $_REQUEST['idCotizacion'];

    $modeloCotizacionesSecciones = new CotizacionesSecciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizacionesSecciones->buscarVehiculos($idCotizacion);
    }else{
        echo json_encode("sesion");
    }
 	
?>