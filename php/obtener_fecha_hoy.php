<?php
    session_start();
    include('../widgets/ObtenerFecha.php');

    $modeloObtenerFecha = new ObtenerFecha();
    $dia=$_REQUEST['dia'];
    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloObtenerFecha->obtenerFechaDia($dia);
    }else{
        echo json_encode("sesion");
    }
    
?>