<?php
    session_start();
	include('../models/Lineas.php');

    $idLinea=$_REQUEST['idLinea'];

    $modeloLineas = new Lineas();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloLineas->buscarLineaUsadoIdLinea($idLinea);
    }else{
        echo json_encode("sesion");
    }
 	
?>