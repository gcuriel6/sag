<?php
    session_start();

	include('../models/Proveedores.php');

    $rfc = $_REQUEST['rfc'];
    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
    
    $modeloProveedores = new Proveedores();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloProveedores->verificarProveedoresAsigna($rfc,$idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>