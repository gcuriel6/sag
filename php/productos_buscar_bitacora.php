<?php
    session_start();
	include('../models/Productos.php');

    $idProducto=$_REQUEST['idProducto'];

    $modeloUsuario = new Productos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarBitacoraProducto($idProducto);
    }else{
        echo json_encode("sesion");
    }
 	
?>