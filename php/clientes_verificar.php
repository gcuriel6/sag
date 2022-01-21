<?php
    session_start();

	include('../models/Clientes.php');

    $nombreComercial = $_REQUEST['nombreComercial'];
    
    $modeloClientes = new Clientes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloClientes->verificarClientes($nombreComercial);
    }else{
        echo json_encode("sesion");
    }
 	
?>