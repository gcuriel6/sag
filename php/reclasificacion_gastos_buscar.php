<?php
    session_start();

	include('../models/ReclasificacionGastos.php');

    $datos = $_REQUEST['datos'];
    
    $modeloReclasificacionGastos = new ReclasificacionGastos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloReclasificacionGastos->buscarReclasificacionGastos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>