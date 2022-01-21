<?php
    session_start();
	include('../models/Autorizar.php');

    $idsUnidades = $_REQUEST['idsUnidades'];
    $idUsuario = $_REQUEST['idUsuario'];
    $idsSucursales = $_REQUEST['idsSucursales'];
    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];

    $modeloAutorizar = new Autorizar();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAutorizar->buscarAutorizar($idsUnidades,$idUsuario,$idsSucursales,$fechaInicio,$fechaFin);
    }else{
        echo json_encode("sesion");
    }
 	
?>