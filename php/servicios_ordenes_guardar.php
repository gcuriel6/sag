<?php
    session_start();
	include('../models/ServiciosOrdenes.php');
   
    $datos = $_REQUEST['datos'];
   
    $modeloServiciosOrdenes = new ServiciosOrdenes();
  
    if (isset($_SESSION['usuario'])){
        
        echo $resultado = $modeloServiciosOrdenes->guardarServiciosOrdenes($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>