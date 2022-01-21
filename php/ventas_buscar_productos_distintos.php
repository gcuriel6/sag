<?php
    session_start();
	include('../models/Ventas.php');

    $idCotizacion = $_REQUEST['idCotizacion'];
 
    $modeloUsuario = new Ventas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscaProductosDistintos($idCotizacion);
    }else{
        echo json_encode("sesion");
    }
 	
?>