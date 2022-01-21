<?php

    session_start();
    include('../models/Empleados.php');

    $idEmpleado = $_REQUEST['idEmpleado'];
    
    $modeloEmpleados = new Empleados();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloEmpleados->buscarEmpleadoId($idEmpleado);
    else
        echo json_encode("sesion");
 	
?>