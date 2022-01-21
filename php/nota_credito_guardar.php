<?php
    session_start();
    include('../models/NotasCredito.php');
    
    $datos = $_REQUEST['datos'];

    $modeloNotasCredito = new NotasCredito();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloNotasCredito->guardarNotaCredito($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>