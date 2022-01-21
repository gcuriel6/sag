<?php
    session_start();
	include('../models/PlantillasCotizaciones.php');

    $estatus=$_REQUEST['estatus'];

    $modeloUsuario = new PlantillasCotizaciones();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarPlantillasCotizaciones($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>