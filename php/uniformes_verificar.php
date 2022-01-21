<?php
    session_start();

	include('../models/Uniformes.php');

    $clave = $_REQUEST['clave'];
    $idSucursal = $_REQUEST['idSucursal'];
    
    $modeloUniformes = new Uniformes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUniformes->verificarUniformes($clave,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>