<?php
    session_start();
	include('../models/Ventas.php');

    $idVenta=$_REQUEST['idVenta'];
    $tipoR=$_REQUEST['tipoR'];
    $idUsuario=$_REQUEST['idUsuario'];

    $modeloUsuario = new Ventas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->cancelarVentas($idVenta,$tipoR,$idUsuario);
    }else{
        echo json_encode("sesion");
    }
 	
?>