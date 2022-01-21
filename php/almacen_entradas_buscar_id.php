<?php
    session_start();
	include('../models/EntradasAlmacen.php');

    $idEntrada = $_REQUEST['idEntrada'];
    
    $modeloEntradasAlmacen = new EntradasAlmacen();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloEntradasAlmacen->buscarEntradasId($idEntrada);
    }else{
        echo json_encode("sesion");
    }
 	
?>