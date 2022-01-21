<?php
    session_start();
	include('../models/ServiciosOrdenesSeguimiento.php');
   
    $idOrdenServicio = $_REQUEST['idOrdenServicio'];
    $fechaAtencion = $_REQUEST['fechaAtencion'];
   
    $modeloServiciosOrdenesSeguimiento = new ServiciosOrdenesSeguimiento();
  
    if (isset($_SESSION['usuario'])){
        
        echo $resultado = $modeloServiciosOrdenesSeguimiento->guardarFechaAtencion($idOrdenServicio,$fechaAtencion);
    }else{
        echo json_encode("sesion");
    }
 	
?>