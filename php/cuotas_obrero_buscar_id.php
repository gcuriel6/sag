<?php
    session_start();
	include('../models/CuotasObrero.php');

    $idCuotaObrero=$_REQUEST['id'];

    $modeloCuotasObrero = new CuotasObrero();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCuotasObrero->buscarCuotasObreroId($idCuotaObrero);
    }else{
        echo json_encode("sesion");
    }
 	
?>