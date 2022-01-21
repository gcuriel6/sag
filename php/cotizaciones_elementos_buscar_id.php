<?php
    session_start();
	include('../models/CotizacionesSecciones.php');

    $idElemento = $_REQUEST['idElemento'];

    $modeloCotizacionesSecciones = new CotizacionesSecciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizacionesSecciones->buscarElementosId($idElemento);
    }else{
        echo json_encode("sesion");
    }
 	
?>