<?php
    session_start();
	include('../models/Servicios.php');
   
    $idServicio = $_REQUEST['idServicio'];
    $correos = $_REQUEST['correos'];
   
    $modeloServicios = new Servicios();
  
    if (isset($_SESSION['usuario'])){
        
        echo $resultado = $modeloServicios->actualizaCorreos($idServicio,$correos);
    }else{
        echo json_encode("sesion");
    }
 	
?>