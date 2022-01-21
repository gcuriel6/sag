<?php
    session_start();
    include('../models/Departamentos.php');
    
    $fecha = $_REQUEST['fecha'];
    $idSucursal = $_REQUEST['idSucursal'];

    $modeloUsuario = new Departamentos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarDepartamentosSinContratos($fecha,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>