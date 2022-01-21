<?php
    session_start();
	include('../models/ProveedoresAccesos.php');

    $datos=$_REQUEST['datos'];

    $modeloProveedoresAccesos = new ProveedoresAccesos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloProveedoresAccesos->ProveedoresAccesosUnidades('agregar',$datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>