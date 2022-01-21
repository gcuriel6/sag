<?php
    session_start();
    include('../models/Proveedores.php');
    
    $idProveedor = $_REQUEST['idProveedor'];

    $modeloProveedores = new Proveedores();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloProveedores->buscarProveedoresId($idProveedor);
    }else{
        echo json_encode("sesion");
    }
 	
?>