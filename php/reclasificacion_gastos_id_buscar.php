<?php
    session_start();

	include('../models/ReclasificacionGastos.php');

    $id = $_REQUEST['id'];
    
    $modeloReclasificacionGastos = new ReclasificacionGastos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloReclasificacionGastos->buscarReclasificacionGastoId($id);
    }else{
        echo json_encode("sesion");
    }
 	
?>