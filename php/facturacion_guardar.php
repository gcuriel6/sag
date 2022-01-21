<?php
    session_start();
	include('../models/Facturacion.php');    

    // print_r($_REQUEST['datos']);

    if(is_array($_REQUEST['datos'])){
        $datos = $_REQUEST['datos'];
    }else{
        $datos = json_decode($_REQUEST['datos'], true);
    }

    // $datos2 = $_POST['datos'];

    // print_r($datos);

    // exit();

    $modeloFacturacion = new Facturacion();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFacturacion->guardarFacturacion($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>