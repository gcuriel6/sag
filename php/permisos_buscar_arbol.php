<?php
    session_start();
	include('../models/Permisos.php');

    $idUsuario=$_REQUEST['idUsuario'];
    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];
    $idSucursal=$_REQUEST['idSucursal'];

    $modeloPermisos = new Permisos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloPermisos->buscarArbol($idUsuario,$idUnidadNegocio,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>