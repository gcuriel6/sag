<?php
    session_start();
	include('../models/PlantillasCotizaciones.php');

    $id=$_REQUEST['id'];

    $modeloPlantillas = new PlantillasCotizaciones();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloPlantillas->buscarPlantillasCotizacionesId($id);
    }else{
        echo json_encode("sesion");
    }
 	
?>