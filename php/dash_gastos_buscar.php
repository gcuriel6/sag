<?php
    session_start();
    include('../models/DashGastos.php');
    
    $datos = $_REQUEST['datos'];

    $modeloDashGastos = new DashGastos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloDashGastos->buscarDashGastos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>