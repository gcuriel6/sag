<?php
    session_start();
    include('../models/Clientes.php');
    
    $datos = $_REQUEST['datos'];

    $modeloClientes = new Clientes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloClientes->buscarSaldosClientesAlarmas($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>