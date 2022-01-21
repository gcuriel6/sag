<?php
    session_start();
	include('../models/OrdenCompra.php');

    $datos = $_REQUEST['datos'];
  
    $modeloOrdenCompra = new OrdenCompra();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloOrdenCompra->guardarOrdenCompra($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>