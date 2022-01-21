<?php
    session_start();
	include('../models/CotizacionesSecciones.php');

    $datos = $_REQUEST['datos'];

    $modeloCotizacionesSecciones = new CotizacionesSecciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizacionesSecciones->guardarConsumibles($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>