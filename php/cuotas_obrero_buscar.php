<?php
    session_start();
	include('../models/CuotasObrero.php');

    $estatus=$_REQUEST['estatus'];

    $modeloCuotasObrero = new CuotasObrero();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCuotasObrero->buscarCuotasObrero($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>