<?php
    session_start();

	include('../models/Productos.php');

    $clave = $_REQUEST['clave'];
    
    $modeloProductos = new Productos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloProductos->verificarProductos($clave);
    }else{
        echo json_encode("sesion");
    }
 	
?>