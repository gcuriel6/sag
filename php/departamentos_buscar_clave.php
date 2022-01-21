<?php
    session_start();
	include('../models/Departamentos.php');

    $idSucursal=$_REQUEST['idSucursal'];

    $modeloDepartamento = new Departamentos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloDepartamento->buscarDepartamentoClave($idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>