<?php
    session_start();
	include('../models/ServiciosOrdenesSeguimiento.php');
   
    $idOrdenServicio = $_REQUEST['idOrdenServicio'];
    $servicio = $_REQUEST['servicio'];
    $proceso = $_REQUEST['proceso'];
    $accionesRealizadas = $_REQUEST['accionesRealizadas'];
    $correos = $_REQUEST['correos'];
    $idTecnico = $_REQUEST['idTecnico'];
    $tecnico = $_REQUEST['tecnico'];
   
    $modeloServiciosOrdenesSeguimiento = new ServiciosOrdenesSeguimiento();
  
    if (isset($_SESSION['usuario'])){
        
        echo $resultado = $modeloServiciosOrdenesSeguimiento->guardarSeguimientoOrdenes($idOrdenServicio,$servicio,$proceso,$accionesRealizadas,$correos,$idTecnico,$tecnico);
    }else{
        echo json_encode("sesion");
    }
 	
?>