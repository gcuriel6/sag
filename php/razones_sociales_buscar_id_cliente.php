<?php
    session_start();
	include('../models/RazonesSociales.php');

    $idCliente=$_REQUEST['idCliente'];

    $modeloCliente = new RazonesSociales();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCliente->buscarRazonesSocialesIdCliente($idCliente);
    }else{
        echo json_encode("sesion");
    }
 	
?>