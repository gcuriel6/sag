<?php
    session_start();
    include('../models/Proveedores.php');
    
    $estatus = $_REQUEST['estatus'];

    $modeloProveedores = new Proveedores();

    if (isset($_SESSION['usuarioP'])){

        echo $resultado = $modeloProveedores->buscarProveedores($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>