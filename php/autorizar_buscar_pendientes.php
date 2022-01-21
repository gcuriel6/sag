<?php
    session_start();
	include('../models/Autorizar.php');

    $idsUnidades = $_REQUEST['idsUnidades'];
    $idUsuario = $_REQUEST['idUsuario'];
    $idSucursales = $_REQUEST['idsSucursales'];

    $modeloAutorizar = new Autorizar();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAutorizar->buscarPendientesAutorizar($idsUnidades,$idUsuario,$idSucursales);
    }else{
        echo json_encode("sesion");
    }
 	
?>