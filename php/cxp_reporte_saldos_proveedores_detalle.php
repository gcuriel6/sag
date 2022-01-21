<?php
    session_start();
    include('../models/CxP.php');

    $idProveedor = $_REQUEST['idProveedor'];

    $modeloCxP = new CxP();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxP->buscarDesgloseSaldosProveedores($idProveedor);
    }else{
        echo json_encode("sesion");
    }
 	
?>