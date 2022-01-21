<?php
    session_start();
	include('../models/SalidasAlmacen.php');

    $datos = $_REQUEST['datos'];
    
    $modeloSalidasAlmacen = new SalidasAlmacen();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloSalidasAlmacen->buscarSalidas($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>