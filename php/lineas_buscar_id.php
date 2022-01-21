<?php
    session_start();
	include('../models/Lineas.php');

    $idLinea=$_REQUEST['idLinea'];

    $modeloUsuario = new Lineas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarLineasId($idLinea);
    }else{
        echo json_encode("sesion");
    }
 	
?>