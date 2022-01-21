<?php
    session_start();
	include('../models/Autorizar.php');

    $idsUnidades = $_REQUEST['idsUnidades'];
    $idUsuario = $_REQUEST['idUsuario'];
    $idsSucursales = $_REQUEST['idsSucursales'];

    $modeloAutorizar = new Autorizar();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAutorizar->buscarRechazadasPresupuesto($idsUnidades,$idUsuario,$idsSucursales);
    }else{
        echo json_encode("sesion");
    }
 	
?>