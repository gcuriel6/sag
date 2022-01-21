<?php
    session_start();
	include('../models/Departamentos.php');

    $datos = $_REQUEST['datos'];
   
    $modeloDepartamentos = new Departamentos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloDepartamentos->guardarDepartamentos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>