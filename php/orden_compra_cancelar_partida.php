<?php
    session_start();
	include('../models/OrdenCompra.php');

    $idOrdenCompra = $_REQUEST['idOrdenCompra'];
    $idPartida = $_REQUEST['id_partida'];
    $idRequisicion = $_REQUEST['idRequisicion'];

    $modeloOrdenCompra = new OrdenCompra();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloOrdenCompra->cancelarPartida($idOrdenCompra,$idPartida,$idRequisicion);
    else
        echo json_encode("sesion");
 	
?>