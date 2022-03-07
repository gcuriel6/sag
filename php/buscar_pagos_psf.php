<?php

    session_start();

    include('../models/Pagos.php');

    $razon_social = $_REQUEST['razon_social'];
    $idCliente = $_REQUEST["idCliente"];

    $modelPagos = new Pagos();

    if (isset($_SESSION['usuario']))
          echo $modelPagos->buscarPagosPSF($razon_social, $idCliente);
    else
        echo json_encode("sesion");
 	
?>