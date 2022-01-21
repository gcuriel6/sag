<?php

    session_start();
    include('../models/Proveedores.php');

    $idUnidad = $_REQUEST['id_unidad'];

    $modeloProveedores = new Proveedores();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloProveedores->buscarProveedoresTodosUnidad($idUnidad);
    else
        echo json_encode("sesion");
 	
?>