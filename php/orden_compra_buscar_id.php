<?php
    session_start();
	include('../models/OrdenCompra.php');

    $idOrdenCompra = $_REQUEST['idOrdenCompra'];
    
    $modeloOrdenCompra = new OrdenCompra();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloOrdenCompra->buscarOrdenCompraId($idOrdenCompra);
    }else{
        echo json_encode("sesion");
    }
 	
?>