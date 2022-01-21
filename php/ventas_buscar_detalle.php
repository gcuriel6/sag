<?php
    session_start();
	include('../models/Ventas.php');

    $idVenta=$_REQUEST['idVenta'];

    $modeloUsuario = new Ventas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarVentasDetalle($idVenta);
    }else{
        echo json_encode("sesion");
    }
 	
?>