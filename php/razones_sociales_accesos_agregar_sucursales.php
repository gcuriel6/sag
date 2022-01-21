<?php
    session_start();
	include('../models/RazonesSocialesAccesos.php');

    $datos=$_REQUEST['datos'];

    $modeloRazonesSocialesAccesos = new RazonesSocialesAccesos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRazonesSocialesAccesos->RazonesSocialesAccesosucursales('agregar',$datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>