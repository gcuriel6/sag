<?php

    session_start();
	include('../models/RazonesSociales.php');

    $datos = $_REQUEST['datos'];
   
    $modeloRazonesSociales = new RazonesSociales();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloRazonesSociales->guardarRazonesSociales($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>