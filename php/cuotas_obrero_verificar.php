<?php
    session_start();

	include('../models/CuotasObrero.php');

    $datos = $_REQUEST['datos'];
    
    $modeloCuotasObrero = new CuotasObrero();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCuotasObrero->verificarCuotasObrero($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>