<?php
    session_start();
    include('../models/CxCAlarmas.php');
    
    $tipo = $_REQUEST['tipo'];
    $id = $_REQUEST['id'];

    $modeloCxCAlarmas = new CxCAlarmas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxCAlarmas->buscarRegistroIdCxC($tipo,$id);
    }else{
        echo json_encode("sesion");
    }
 	
?>