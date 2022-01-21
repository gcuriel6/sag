<?php
    session_start();
	include('../models/CargarDatos.php');

    $idCxP=$_REQUEST['idCxP'];

    $modeloCargarDatos = new CargarDatos();

    if (isset($_SESSION['usuarioP'])){

          echo $resultado = $modeloCargarDatos->buscarComplementosPago($idCxP);
    }else{
        echo json_encode("sesion");
    }
 	
?>