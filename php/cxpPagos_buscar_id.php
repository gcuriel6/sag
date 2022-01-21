<?php
    session_start();
    include('../models/CxpPagos.php');
    
    $id = $_REQUEST['id'];
    $tipo = $_REQUEST['tipo'];

    $modeloCxpPagos = new CxpPagos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCxpPagos->buscarDetalleRegistro($id,$tipo);
    }else{
        echo json_encode("sesion");
    }
 	
?>