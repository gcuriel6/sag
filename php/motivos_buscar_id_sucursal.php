<?php
    session_start();
    include('../models/Motivos.php');
    
    $idSucursal = $_REQUEST['idSucursal'];
    //$idUnidadNegocio = $_REQUEST['idUnidadNegocio'];

    $modeloMotivos = new Motivos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloMotivos->buscarMotivosIdSucursal($idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>