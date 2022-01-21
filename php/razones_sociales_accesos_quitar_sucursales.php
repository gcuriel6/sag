<?php
    session_start();
	include('../models/RazonesSocialesAccesos.php');

    $datos=$_REQUEST['datos'];
 
    $modeloRazonesSocialesAccesos = new RazonesSocialesAccesos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRazonesSocialesAccesos->RazonesSocialesAccesosucursales('quitar',$datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>