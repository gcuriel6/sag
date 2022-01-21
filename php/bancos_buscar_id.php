<?php
    session_start();
	include('../models/Bancos.php');

    $idBanco=$_REQUEST['idBanco'];

    $modeloUsuario = new Bancos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarBancosId($idBanco);
    }else{
        echo json_encode("sesion");
    }
 	
?>