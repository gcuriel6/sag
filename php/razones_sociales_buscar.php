<?php
    session_start();
	include('../models/RazonesSociales.php');

    $estatus=$_REQUEST['estatus'];

    $modeloCliente = new RazonesSociales();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCliente->buscarRazonesSociales($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>