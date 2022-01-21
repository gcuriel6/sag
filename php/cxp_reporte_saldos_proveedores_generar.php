<?php
    session_start();
    include('../models/CxP.php');
    
    $modeloCxP = new CxP();

    $idProveedor = $_REQUEST['idProveedor'];

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxP->generaReporteSaldosProveedores($idProveedor);
    }else{
        echo json_encode("sesion");
    }
 	
?>