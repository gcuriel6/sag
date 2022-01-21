<?php
    session_start();
	include('../models/UnidadesNegocio.php');

    $idUnidadNegocio=$_REQUEST['idUnidadesNegocio'];

    $modeloUnidadNegocio = new UnidadesNegocio();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUnidadNegocio->buscarUnidadesNegocio($idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>