<?php
    session_start();
	include('../models/SalidasAlmaceII.php');

    $datos = $_REQUEST['datos'];
    
    $modeloSalidasAlmacen = new SalidasAlmaceII();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloSalidasAlmacen->guardarSalidas($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>