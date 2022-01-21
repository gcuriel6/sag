<?php
    session_start();
	include('../models/CotizacionesSecciones.php');

    $idConsumible = $_REQUEST['idConsumible'];

    $modeloCotizacionesSecciones = new CotizacionesSecciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizacionesSecciones->eliminarConsumibles($idConsumible);
    }else{
        echo json_encode("sesion");
    }
 	
?>