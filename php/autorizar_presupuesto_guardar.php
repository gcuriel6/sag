<?php
    session_start();
	include('../models/AutorizarPresupuesto.php');

    $id = $_REQUEST['id'];
    $estatus = $_REQUEST['estatus'];
    $idUsuario = $_REQUEST['idUsuario'];
    $fecha = $_REQUEST['fecha'];


    $modeloAutorizarPresupuesto = new AutorizarPresupuesto();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAutorizarPresupuesto->guardarAutorizarPresupuesto($id,$estatus,$idUsuario,$fecha);
    }else{
        echo json_encode("sesion");
    }
 	
?>