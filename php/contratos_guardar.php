<?php
    session_start();
	include('../models/Contratos.php');

    $datos = $_REQUEST['datos'];
   
    $modeloContratos = new Contratos();

    if (isset($_SESSION['usuario'])){
      
        echo $resultado = $modeloContratos->guardarContratos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>