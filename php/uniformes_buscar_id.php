<?php
    session_start();
	include('../models/Uniformes.php');

    $idUniforme=$_REQUEST['idUniforme'];

    $modeloUniforme = new Uniformes();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUniforme->buscarUniformesId($idUniforme);
    }else{
        echo json_encode("sesion");
    }
 	
?>