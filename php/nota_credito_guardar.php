<?php
    session_start();
    include('../models/NotasCredito.php');
    // error_log("Comenzando pariente*****************************");
    // error_log("verificando sesion0");
    // error_log(json_encode($_SESSION));
    
    $datos = $_REQUEST['datos'];

    $modeloNotasCredito = new NotasCredito();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloNotasCredito->guardarNotaCredito($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>