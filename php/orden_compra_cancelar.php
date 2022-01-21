<?php
    session_start();
	include('../models/OrdenCompra.php');

    $idOrden = $_REQUEST['id_orden_compra'];
    $modeloOrdenCompra = new OrdenCompra();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloOrdenCompra->cancelarOden($idOrden);
    else
        echo json_encode("sesion");
 	
?>