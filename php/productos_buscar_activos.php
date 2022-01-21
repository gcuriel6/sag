<?php

    session_start();

    include('../models/Productos.php');

    $idUnidad = $_REQUEST['idUnidad'];
    $idFamilia = $_REQUEST['idFamilia'];
    $idLinea = $_REQUEST['idLinea'];
    $tipo = $_REQUEST['tipo'];
    //-->NJES July/30/2020 si diferentes familias es 1 no buscar familias gasto de caja chica y gasolina
    $diferentesFamilias = isset($_REQUEST['diferentesFamilias']) ? $_REQUEST['diferentesFamilias'] : 0;

    $modelProductos = new Productos();

    if (isset($_SESSION['usuario']))
          echo $modelProductos->buscarProductosActivos($idUnidad, $idFamilia, $idLinea, $tipo, $diferentesFamilias);
    else
        echo json_encode("sesion");
 	
?>