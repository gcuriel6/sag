<?php
    session_start();
	include('../models/Productos.php');

    $estatus=$_REQUEST['estatus'];

    $modeloUsuario = new Productos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarProductos($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>