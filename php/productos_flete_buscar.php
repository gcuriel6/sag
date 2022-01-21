<?php
    session_start();
	include('../models/Productos.php');

    $modeloUsuario = new Productos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarProductosFletesLogistica();
    }else{
        echo json_encode("sesion");
    }
 	
?>