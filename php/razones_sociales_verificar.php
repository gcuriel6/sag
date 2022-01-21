<?php
    session_start();

	include('../models/RazonesSociales.php');

    $nombreCorto = $_REQUEST['nombreCorto'];
    
    $modeloRazonesSociales = new RazonesSociales();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRazonesSociales->verificarRazonesSociales($nombreCorto);
    }else{
        echo json_encode("sesion");
    }
 	
?>