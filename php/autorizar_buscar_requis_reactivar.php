<?php
    session_start();
	include('../models/Autorizar.php');

    $idsUnidades = $_REQUEST['idsUnidades'];
    $idUsuario = $_REQUEST['idUsuario'];
    $idsSucursales = $_REQUEST['idsSucursal'];

    $modeloAutorizar = new Autorizar();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAutorizar->buscarRequisReactivar($idsUnidades,$idUsuario,$idsSucursales);
    }else{
        echo json_encode("sesion");
    }
 	
?>