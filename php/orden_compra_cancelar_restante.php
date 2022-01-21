<?php
    session_start();
	include('../models/OrdenCompra.php');

    $idPartida = $_REQUEST['id_partida'];
    $entregados = $_REQUEST['entregados'];
    $modeloOrdenCompra = new OrdenCompra();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloOrdenCompra->cancelarRestante($idPartida,$entregados);
    else
        echo json_encode("sesion");
 	
?>