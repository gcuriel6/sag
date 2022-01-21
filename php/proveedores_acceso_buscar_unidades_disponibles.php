<?php
    session_start();
    include('../models/ProveedoresAccesos.php');
    
    $idProveedor=$_REQUEST['idProveedor'];

    $modeloProveedoresAccesos = new ProveedoresAccesos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloProveedoresAccesos->buscarUnidadesDisponibles($idProveedor);
    }else{
        echo json_encode("sesion");
    }
 	
?>