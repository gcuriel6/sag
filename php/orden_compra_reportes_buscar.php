<?php
    session_start();
    include('../models/OrdenCompra.php');
    
    $datos = $_REQUEST['datos'];

    $modelOrdenCompra = new OrdenCompra();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modelOrdenCompra->buscarOrdenCompraReportes($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>