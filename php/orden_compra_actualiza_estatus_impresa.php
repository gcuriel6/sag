<?php
    session_start();
	include('../models/OrdenCompra.php');

    $idOrden = $_REQUEST['idOrden'];
    $modeloOrdenCompra = new OrdenCompra();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloOrdenCompra->imprimirOden($idOrden);
    else
        echo json_encode("sesion");
 	
?>