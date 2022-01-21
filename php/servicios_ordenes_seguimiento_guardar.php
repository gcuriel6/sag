<?php
    session_start();
	include('../models/ServiciosOrdenesSeguimiento.php');
   
    $idOrdenServicio = $_REQUEST['idOrdenServicio'];
    $servicio = $_REQUEST['servicio'];
    $proceso = $_REQUEST['proceso'];
    $accionesRealizadas = $_REQUEST['accionesRealizadas'];
    $correos = $_REQUEST['correos'];
   
    $modeloServiciosOrdenesSeguimiento = new ServiciosOrdenesSeguimiento();
  
    if (isset($_SESSION['usuario'])){
        
        echo $resultado = $modeloServiciosOrdenesSeguimiento->guardarServiciosOrdenesSeguimiento($idOrdenServicio,$servicio,$proceso,$accionesRealizadas,$correos);
    }else{
        echo json_encode("sesion");
    }
 	
?>