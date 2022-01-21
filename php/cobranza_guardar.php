<?php
    session_start();
	include('../models/Cobranza.php');

    $datos=$_REQUEST['datos'];

    $modeloCobranza = new Cobranza();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCobranza->guardarCobranza($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>