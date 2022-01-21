<?php

    session_start();
    include('../models/Proveedores.php');

    $idUnidad = $_REQUEST['id_unidad'];
    $rfc = $_REQUEST['rfc'];

    $modeloProveedores = new Proveedores();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloProveedores->buscarProveedoresAprobadosUnidad($idUnidad,$rfc);
    else
        echo json_encode("sesion");
 	
?>