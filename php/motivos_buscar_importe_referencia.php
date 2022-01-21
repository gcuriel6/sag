<?php
    session_start();
    include('../models/Motivos.php');

    $id_referencia=$_REQUEST['id_referencia'];
    $idUnidadNegocio=$_REQUEST['idUnidadNegocio'];
    
    $modeloMotivos = new Motivos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloMotivos->buscarMotivosImportesReferencia($id_referencia,$idUnidadNegocio);
    }else{
        echo json_encode("sesion");
    }
 	
?>