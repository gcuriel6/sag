<?php

    session_start();

    include('../models/Productos.php');

    $idUnidad = $_REQUEST['idUnidadNegocio'];

    $modelProductos = new Productos();

    if (isset($_SESSION['usuario']))
          echo $modelProductos->buscarProductosMateriaPrima($idUnidad);
    else
        echo json_encode("sesion");
 	
?>