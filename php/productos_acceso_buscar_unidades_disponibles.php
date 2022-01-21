<?php
    session_start();
    include('../models/ProductosAccesos.php');
    
    $idProducto=$_REQUEST['idProducto'];

    $modeloProductosAccesos = new ProductosAccesos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloProductosAccesos->buscarUnidadesDisponibles($idProducto);
    }else{
        echo json_encode("sesion");
    }
 	
?>