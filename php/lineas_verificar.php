<?php
    session_start();

	include('../models/Lineas.php');

    $clave = $_REQUEST['clave'];
    
    $modeloLineas = new Lineas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloLineas->verificarLineas($clave);
    }else{
        echo json_encode("sesion");
    }
 	
?>