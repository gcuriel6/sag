<?php
    session_start();
	include('../models/Productos.php');

    $datos = $_REQUEST['datos'];
   
    $modeloProductos = new Productos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloProductos->guardarProductos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>