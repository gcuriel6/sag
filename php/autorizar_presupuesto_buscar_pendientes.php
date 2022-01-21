<?php
    session_start();
	include('../models/AutorizarPresupuesto.php');

    $idsUnidades = $_REQUEST['idsUnidades'];
    $idUsuario = $_REQUEST['idUsuario'];
    $idsSucursales = $_REQUEST['idsSucursales'];

    $modeloAutorizarPresupuesto = new AutorizarPresupuesto();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAutorizarPresupuesto->buscarPendientesAutorizarPresupuesto($idsUnidades,$idUsuario,$idsSucursales);
    }else{
        echo json_encode("sesion");
    }
 	
?>