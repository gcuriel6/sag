<?php
    session_start();
	include('../models/CodigoPostal.php');

    $idEstado=$_REQUEST['idEstado'];
    $idMunicipio=$_REQUEST['idMunicipio'];

    $modeloCodigoPostal = new CodigoPostal();

    if (isset($_SESSION['usuarioP'])){

          echo $resultado = $modeloCodigoPostal->buscarCodigoPostal($idEstado,$idMunicipio);
    }else{
        echo json_encode("sesion");
    }
 	
?>