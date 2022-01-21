<?php
    session_start();
	include('../models/Proveedores.php');

    $idProveedor = $_REQUEST['idProveedor'];
    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];

    $modeloProveedores = new Proveedores();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloProveedores->asignarProveedores($idProveedor,$idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>