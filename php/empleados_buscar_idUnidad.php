<?php

    session_start();
    include('../models/Empleados.php');

    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
    
    $modeloEmpleados = new Empleados();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloEmpleados->buscarEmpleadosIdUnidad($idUnidadNegocio);
    else
        echo json_encode("sesion");
 	
?>