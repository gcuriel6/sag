<?php
    session_start();
	include('../models/Proveedores.php');

    $datos = $_REQUEST['datos'];

    $modeloProveedores = new Proveedores();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloProveedores->guardarProveedores($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>