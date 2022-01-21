<?php
    session_start();
	include('../models/ServiciosOrdenesSeguimiento.php');
   
    $idOrdenServicio = $_REQUEST['idOrdenServicio'];
    $servicio = $_REQUEST['servicio'];
    $proceso = $_REQUEST['proceso'];
    $accionesRealizadas = $_REQUEST['accionesRealizadas'];
    $correos = $_REQUEST['correos'];
    $sinCobro = $_REQUEST['sinCobro'];
   
    $modeloServiciosOrdenesSeguimiento = new ServiciosOrdenesSeguimiento();
  
    if (isset($_SESSION['usuario'])){
        
        echo $resultado = $modeloServiciosOrdenesSeguimiento->guardarSinCobrarOrdenes($idOrdenServicio,$servicio,$proceso,$accionesRealizadas,$correos,$sinCobro);
    }else{
        echo json_encode("sesion");
    }
 	
?>