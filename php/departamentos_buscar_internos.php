<?php
    session_start();
    include('../models/Departamentos.php');
    
    $idUnidad=$_REQUEST['idUnidad'];

    $modeloUsuario = new Departamentos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarDepartamentosInternos($idUnidad);
    }else{
        echo json_encode("sesion");
    }
 	
?>