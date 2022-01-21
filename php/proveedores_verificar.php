<?php
    session_start();

	include('../models/Proveedores.php');

    $rfc = $_REQUEST['rfc'];
    
    $modeloProveedores = new Proveedores();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloProveedores->verificarProveedores($rfc);
    }else{
        echo json_encode("sesion");
    }
 	
?>