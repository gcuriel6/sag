<?php
    session_start();
	include('../models/Empleados.php');

    $idEmpleado = isset($_REQUEST['idEmpleado']) ? $_REQUEST['idEmpleado'] : 0;
    $filtroId  = $_REQUEST['filtroId'];
    $filtroNombre = $_REQUEST['filtroNombre'];

    $modeloEmpleados= new Empleados();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloEmpleados->buscarEmpleadosTodos($idEmpleado,$filtroId,$filtroNombre);
    }else{
        echo json_encode("sesion");
    }
 	
?>