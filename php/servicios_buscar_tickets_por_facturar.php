<?php
    session_start();
	include('../models/Servicios.php');

    $idServicio = $_REQUEST['idServicio'];
    $rfc = $_REQUEST['rfc'];

    $modeloCliente = new Servicios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCliente->buscaTicketsPorFacturar($idServicio,$rfc);
    }else{
        echo json_encode("sesion");
    }
 	
?>