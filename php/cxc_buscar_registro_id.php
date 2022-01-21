<?php
    session_start();
    include('../models/CxC.php');
    
    $tipo = $_REQUEST['tipo'];
    $id = $_REQUEST['id'];

    $modeloCxC = new CxC();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxC->buscarRegistroIdCxC($tipo,$id);
    }else{
        echo json_encode("sesion");
    }
 	
?>