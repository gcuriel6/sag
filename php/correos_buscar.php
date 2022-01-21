<?php
    session_start();
	include('../models/Correos.php');
   
    $modeloCorreos = new Correos();

    if (isset($_SESSION['usuario'])){
      
        echo $resultado = $modeloCorreos->buscarCorreos();
    }else{
        echo json_encode("sesion");
    }
 	
?>