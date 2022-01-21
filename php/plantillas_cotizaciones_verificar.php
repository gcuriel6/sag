<?php
    session_start();

	include('../models/PlantillasCotizaciones.php');

    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
    
    $modeloPlantillasCotizaciones = new PlantillasCotizaciones();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloPlantillasCotizaciones->verificarPlantillasCotizaciones($idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>