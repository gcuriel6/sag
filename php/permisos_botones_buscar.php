<?php
    session_start();
	include('../widgets/VerificarPermiso.php');

    $idUsuario = $_REQUEST['idUsuario'];
    $boton = $_REQUEST['boton'];
    $idBoton = $_REQUEST['idBoton'];
    $idSucursal = $_REQUEST['idSucursal'];
    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];

    $modeloVerificarPermisosBotones = new VerificarPermiso();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloVerificarPermisosBotones->buscarPermisosBotones($idUsuario,$boton,$idBoton,$idSucursal,$idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>