<?php
    session_start();
    include('../models/CajaChica.php');
    
    $datos = $_REQUEST['datos'];

    $modeloCajaChica = new CajaChica();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCajaChica->buscarCajaChicaReporte($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>