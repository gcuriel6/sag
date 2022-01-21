<?php

    session_start();
    include('../models/Empleados.php');

    $idsSucursales = $_REQUEST['idsSucursales'];
    $modulo = $_REQUEST['modulo'];
    
    $modeloEmpleados = new Empleados();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloEmpleados->buscarEmpleadosIdsSucursales($idsSucursales,$modulo);
    else
        echo json_encode("sesion");
 	
?>