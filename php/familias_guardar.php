<?php
    session_start();
	include('../models/Familias.php');

    $datos = $_REQUEST['datos'];
   
    $modeloFamilias = new Familias();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFamilias->guardarFamilias($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>