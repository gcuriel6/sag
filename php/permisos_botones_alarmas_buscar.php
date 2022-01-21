<?php
    session_start();
	include('../widgets/VerificarPermiso.php');

    $idUsuario = $_REQUEST['idUsuario'];
    $boton = $_REQUEST['boton'];
    $idBoton = $_REQUEST['idBoton'];
    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];

    $modeloVerificarPermisosBotones = new VerificarPermiso();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloVerificarPermisosBotones->buscarPermisosBotonesAlarmas($idUsuario,$boton,$idBoton,$idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>