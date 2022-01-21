<?php
    session_start();

	include('../models/Areas.php');

    $clave = $_REQUEST['clave'];
    
    $modeloAreas = new Areas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloAreas->verificarAreas($clave);
    }else{
        echo json_encode("sesion");
    }
 	
?>