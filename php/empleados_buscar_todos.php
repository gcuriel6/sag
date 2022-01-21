<?php
    session_start();
	include('../models/Empleados.php');

    $idEmpleado = $_REQUEST['idEmpleado'];
    $filtroId  = $_REQUEST['filtroId'];
    $filtroNombre = $_REQUEST['filtroNombre'];
 	$idUnidadNegocio = $_REQUEST['idUnidadActual'];
 	$idSucursal = $_REQUEST['idSucursal'];	

    $modeloEmpleados= new Empleados();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloEmpleados->buscarEmpleadosTodos($idEmpleado,$filtroId,$filtroNombre);
    }else{
        echo json_encode("sesion");
    }
 	
?>