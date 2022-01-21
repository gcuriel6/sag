<?php
    session_start();

	include('../models/Familias.php');

    $clave = $_REQUEST['clave'];
    
    $modeloFamilias = new Familias();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFamilias->verificarFamilias($clave);
    }else{
        echo json_encode("sesion");
    }
 	
?>