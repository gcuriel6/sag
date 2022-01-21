<?php
    session_start();
	include('../models/Almacenes.php');
  
    $modeloAlmacenes = new Almacenes();

    $idSucursal = (isset($_REQUEST['idSucursal'])>0)?$_REQUEST['idSucursal']:0;

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloAlmacenes->buscaFoliosActivoFijos($idSucursal);
        
    }else{
        echo json_encode("sesion");
    }
 	
?>