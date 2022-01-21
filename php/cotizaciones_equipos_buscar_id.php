<?php
    session_start();
	include('../models/CotizacionesSecciones.php');

    $idEquipo = $_REQUEST['idEquipo'];

    $modeloCotizacionesSecciones = new CotizacionesSecciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizacionesSecciones->buscarEquiposId($idEquipo);
    }else{
        echo json_encode("sesion");
    }
 	
?>