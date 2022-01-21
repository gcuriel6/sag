<?php
    session_start();
	include('../models/Autorizar.php');

    $idRequisicion = $_REQUEST['idRequisicion'];

    $modeloAutorizar = new Autorizar();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAutorizar->buscaNumeroAbonosCxpRequisicion($idRequisicion);
    }else{
        echo json_encode("sesion");
    }
 	
?>