<?php
    session_start();
	include('../models/CotizacionesSecciones.php');

    $idCotizacion = $_REQUEST['idCotizacion'];

    $modeloCotizacionesSecciones = new CotizacionesSecciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizacionesSecciones->buscarEquipos($idCotizacion);
    }else{
        echo json_encode("sesion");
    }
 	
?>