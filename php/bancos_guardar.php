<?php
    session_start();
	include('../models/Bancos.php');

    $datos = $_REQUEST['datos'];
   
    $modeloBancos = new Bancos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloBancos->guardarBancos($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>