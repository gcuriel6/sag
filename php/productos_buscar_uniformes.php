<?php

    session_start();

	include('../models/Productos.php');

    $idUnidad = $_REQUEST['idUnidad'];
    $idFamilia = $_REQUEST['idFamilia'];
    $idLinea = $_REQUEST['idLinea'];

    $modelProductos = new Productos();

    if (isset($_SESSION['usuario']))
          echo $modelProductos->buscarProductosActivosUniformes($idUnidad, $idFamilia, $idLinea);
    else
        echo json_encode("sesion");
 	
?>