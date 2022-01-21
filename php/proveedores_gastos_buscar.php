<?php
    session_start();
    include('../models/Proveedores.php');
    
    $estatus = $_REQUEST['estatus'];

    $modeloProveedores = new Proveedores();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloProveedores->buscarProveedoresGastos($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>