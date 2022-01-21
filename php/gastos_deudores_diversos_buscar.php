<?php

    session_start();
    include('../models/Gastos.php');
    
    $modeloGastos = new Gastos();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloGastos->buscarGastosEmpleadosDeudoresDiversos();
    else
        echo json_encode("sesion");
 	
?>