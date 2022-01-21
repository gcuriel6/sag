<?php
    session_start();

	include('../models/Bancos.php');

    $clave = $_REQUEST['clave'];
    
    $modeloBancos = new Bancos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloBancos->verificarBancos($clave);
    }else{
        echo json_encode("sesion");
    }
 	
?>