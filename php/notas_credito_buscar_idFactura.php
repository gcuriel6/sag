<?php
    session_start();
    include('../models/NotasCredito.php');
    
    $idFactura = $_REQUEST['idFactura'];

    $modeloNotasCredito = new NotasCredito();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloNotasCredito->buscarNotasCreditoidFactura($idFactura);
    }else{
        echo json_encode("sesion");
    }
 	
?>