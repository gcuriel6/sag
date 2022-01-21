<?php
    session_start();
	include('../models/CotizacionesVersiones.php');

    $datos = $_REQUEST['datos'];
    
    $modeloCotizacionesVersiones = new CotizacionesVersiones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCotizacionesVersiones->guardarVersionCotizacion($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>