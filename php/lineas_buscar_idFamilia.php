<?php
    session_start();
	include('../models/Lineas.php');

    $idFamilia=$_REQUEST['idFamilia'];

    $modeloUsuario = new Lineas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarLineasIdFamilia($idFamilia);
    }else{
        echo json_encode("sesion");
    }
 	
?>