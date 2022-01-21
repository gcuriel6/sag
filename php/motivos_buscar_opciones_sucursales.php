<?php
    session_start();
    include('../models/Motivos.php');

    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];
    
    $modeloMotivos = new Motivos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloMotivos->buscarMotivosOpcionesSucursales($idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>