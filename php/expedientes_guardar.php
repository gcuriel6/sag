<?php
    session_start();
	include('../models/Expedientes.php');

    $datos = $_REQUEST['datos'];

    $modeloExpedientes = new Expedientes();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloExpedientes->guardarExpedientes($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>