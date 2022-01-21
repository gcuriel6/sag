<?php
    session_start();
	include('../models/Areas.php');

    $idArea=$_REQUEST['idArea'];

    $modeloUsuario = new Areas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarAreasId($idArea);
    }else{
        echo json_encode("sesion");
    }
 	
?>