<?php
    session_start();
	include('../models/Empleados.php');

	$idEmpleado = $_REQUEST['idEmpleado'];
 	$idUnidadNegocio = $_REQUEST['idUnidadActual'];
 	$idSucursal = $_REQUEST['idSucursal'];	

    $modeloEmpleados= new Empleados();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloEmpleados->buscarEmpleadosSupervisor($idEmpleado);
    }else{
        echo json_encode("sesion");
    }
 	
?>