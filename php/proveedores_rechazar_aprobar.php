<?php
    session_start();
    include('../models/Proveedores.php');
    
    $idProveedor = $_REQUEST['idProveedor'];
    $rechazar = $_REQUEST['rechazar'];
    $aprobar = $_REQUEST['aprobar'];

    $modeloProveedores = new Proveedores();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloProveedores->rechazarAprobarProveedor($idProveedor,$rechazar,$aprobar);
    }else{
        echo json_encode("sesion");
    }
 	
?>