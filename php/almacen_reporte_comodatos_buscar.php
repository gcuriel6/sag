<?php
    session_start();
	include('../models/Almacenes.php');

    $datos = $_REQUEST['datos'];
    
    $modeloAlmacenes = new Almacenes();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloAlmacenes->buscarComodatosAlmacenReporte($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>