<?php
    session_start();
	include('../models/Salarios.php');

    $datos = $_REQUEST['datos'];

    $modeloSalarios = new Salarios();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloSalarios->guardarSalarios($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>