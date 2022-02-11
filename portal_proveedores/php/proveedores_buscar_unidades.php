<?php

    session_start();
    include('../models/Proveedores.php');

    $idUnidad = $_REQUEST['id_unidad'];

    $modeloProveedores = new Proveedores();
    
    echo $resultado = $modeloProveedores->buscarProveedoresUnidad($idUnidad);
 	
?>