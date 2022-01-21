<?php
    session_start();
	include('../models/Recibos.php');

    $idServicio=$_REQUEST['idServicio'];

    $modeloRecibos = new Recibos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRecibos->buscarPlanIdServicio($idServicio);
    }else{
        echo json_encode("sesion");
    }
 	
?>