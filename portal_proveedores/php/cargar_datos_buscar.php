<?php
    session_start();
	include('../models/CargarDatos.php');

    $idProveedor=$_REQUEST['idProveedor'];

    $modeloCargarDatos = new CargarDatos();

    if (isset($_SESSION['usuarioP'])){

          echo $resultado = $modeloCargarDatos->buscarCargarDatos($idProveedor);
    }else{
        echo json_encode("sesion");
    }
 	
?>