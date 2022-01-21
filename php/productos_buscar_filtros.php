<?php
    session_start();
	include('../models/Productos.php');

    $idFamilia = $_REQUEST['idFamilia'];
    $idLinea = $_REQUEST['idLinea'];

    $modeloUsuario = new Productos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarProductosFiltros($idFamilia,$idLinea);
    }else{
        echo json_encode("sesion");
    }
 	
?>