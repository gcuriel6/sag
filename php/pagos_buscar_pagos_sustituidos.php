<?php
    session_start();
    include('../models/Pagos.php');
    
    $idPago = $_REQUEST['idPago'];

    $modelPagos = new Pagos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modelPagos->buscarPagosSustituidosId($idPago);
    }else{
        echo json_encode("sesion");
    }
 	
?>