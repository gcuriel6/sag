<?php
    session_start();
	include('../models/Servicios.php');

    $idServicio=$_REQUEST['idServicio'];

    $modeloCliente = new Servicios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCliente->buscaTicketsSinFacturar($idServicio);
    }else{
        echo json_encode("sesion");
    }
 	
?>