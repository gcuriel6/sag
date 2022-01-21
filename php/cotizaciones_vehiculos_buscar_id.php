<?php
    session_start();
	include('../models/CotizacionesSecciones.php');

    $idVehiculo = $_REQUEST['idVehiculo'];

    $modeloCotizacionesSecciones = new CotizacionesSecciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizacionesSecciones->buscarVehiculosId($idVehiculo);
    }else{
        echo json_encode("sesion");
    }
 	
?>