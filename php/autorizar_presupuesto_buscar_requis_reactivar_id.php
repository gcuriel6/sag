<?php
    session_start();
	include('../models/Autorizar.php');

    $idRequisicion = $_REQUEST['idRequisicion'];
    $idUsuario = $_REQUEST['idUsuario'];

    $modeloAutorizar = new Autorizar();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAutorizar->buscarRequisReactivarId($idRequisicion);
    }else{
        echo json_encode("sesion");
    }
 	
?>