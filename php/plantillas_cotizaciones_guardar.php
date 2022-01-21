<?php
    session_start();
	include('../models/PlantillasCotizaciones.php');

    $datos = $_REQUEST['datos'];
   
    $modeloPlantillasCotizaciones = new PlantillasCotizaciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloPlantillasCotizaciones->guardarPlantillasCotizaciones($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>