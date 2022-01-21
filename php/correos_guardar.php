<?php
    session_start();
	include('../models/Correos.php');

    $correos = $_REQUEST['correos'];
   
    $modeloCorreos = new Correos();

    if (isset($_SESSION['usuario'])){
      
        echo $resultado = $modeloCorreos->guardarCorreos($correos);
    }else{
        echo json_encode("sesion");
    }
 	
?>