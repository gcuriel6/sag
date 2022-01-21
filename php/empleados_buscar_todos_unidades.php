<?php

    session_start();
    include('../models/Empleados.php');
    
    $modeloEmpleados = new Empleados();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloEmpleados->buscarEmpleadosTodosUnidades();
    else
        echo json_encode("sesion");
 	
?>