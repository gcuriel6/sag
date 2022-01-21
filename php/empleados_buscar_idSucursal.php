<?php

    session_start();
    include('../models/Empleados.php');

    $idSucursal = $_REQUEST['idSucursal'];
    
    $modeloEmpleados = new Empleados();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloEmpleados->buscarEmpleadosIdSucursal($idSucursal);
    else
        echo json_encode("sesion");
 	
?>