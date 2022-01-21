<?php
    session_start();
	include('../models/ProductosAccesos.php');

    $datos=$_REQUEST['datos'];

    $modeloProductosAccesos = new ProductosAccesos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloProductosAccesos->ProductosAccesosUnidades('agregar',$datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>