<?php
    session_start();
	include('../models/PlantillasCotizaciones.php');

    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];

    $modeloPlantillas = new PlantillasCotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloPlantillas->buscarPlantillasCotizacionesIdUnidad($idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>