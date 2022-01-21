<?php
    session_start();
	include('../models/Bancos.php');

    $estatus=$_REQUEST['estatus'];

    $modeloBancos = new Bancos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloBancos->buscarBancos($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>