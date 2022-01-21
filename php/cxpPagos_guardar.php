<?php
    session_start();
    include('../models/CxpPagos.php');
    
    $datos = $_REQUEST['datos'];

    $modeloCxpPagos = new CxpPagos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCxpPagos->guardarCxP($datos);
       
    }else{
        echo json_encode("sesion");
    }
 	
?>