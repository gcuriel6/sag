<?php
    session_start();
	include('../models/Familias.php');

    $idFamilia=$_REQUEST['idFamilia'];

    $modeloFamilias = new Familias();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFamilias->buscarFamiliasId($idFamilia);
    }else{
        echo json_encode("sesion");
    }
 	
?>