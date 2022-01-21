<?php
    session_start();
	include('../models/EntradasAlmacen.php');

    $datos = $_REQUEST['datos'];
    
    $modeloEntradasAlmacen = new EntradasAlmacen();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloEntradasAlmacen->guardarEntradas($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>