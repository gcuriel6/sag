<?php

    session_start();
    include('../models/Facturacion.php');
    $facturacion = new Facturacion();

    if (isset($_SESSION['usuario']))
        echo $resultado = $facturacion->buscarFacturasProceso();
    else
        echo json_encode("sesion");
 	
?>