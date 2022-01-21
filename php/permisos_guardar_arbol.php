<?php
    session_start();
	include('../models/Permisos.php');

    $usuario = $_REQUEST['usuario'];
    $idUsuario = $_REQUEST['idUsuario'];
    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
    $idsSucursales = $_REQUEST['idsSucursales'];
    $datos = $_REQUEST['permisos'];
  
    $modeloPermisos = new Permisos();

    if (isset($_SESSION['usuario']))
    {

          echo $resultado = $modeloPermisos->guardarPermisos($usuario,$idUsuario,$idUnidadNegocio,$idsSucursales,$datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>