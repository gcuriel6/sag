<?php
    session_start();
    include('../models/Pagos.php');
    
    $datos = $_REQUEST['datos'];

    $modelPagos = new Pagos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modelPagos->guardarPagos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>