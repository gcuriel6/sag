<?php
    session_start();
    include('../models/CxpPagos.php');
    
    $ordenar = $_REQUEST['ordenar'];
    $tipo = $_REQUEST['tipo'];

    $modeloCxpPagos = new CxpPagos();

    if (isset($_SESSION['usuario'])){

        /*if($tipo == 1)
        {
            echo $resultado = $modeloCxpPagos->buscarCxPVencidos($ordenar);
        }else{
            echo $resultado = $modeloCxpPagos->buscarCxPPorVencer($ordenar);
        }*/

        echo $resultado = $modeloCxpPagos->buscarCxPPagos($ordenar,$tipo);

    }else{
        echo json_encode("sesion");
    }
 	
?>