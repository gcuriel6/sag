<?php
    session_start();
	include('../models/TiposIngresos.php');

    $idTipoIngreso=$_REQUEST['idTipoIngreso'];

    $modeloUsuario = new TiposIngresos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarTiposIngresosId($idTipoIngreso);
    }else{
        echo json_encode("sesion");
    }
 	
?>