<?php
    session_start();
	include('../models/CargarDatos.php');

   
    $idProveedor = $_REQUEST['idProveedor'];
    $folioOc = $_REQUEST['folioOc'];
    $folioEntrada = $_REQUEST['folioEntrada'];

    $modeloCargarDatos = new CargarDatos();

    // print_r($_REQUEST);
    // exit();

    if (isset($_SESSION['usuarioP'])){

        echo $resultado = $modeloCargarDatos->validarCargarDatos($idProveedor,$folioOc,$folioEntrada);
    }else{
        echo json_encode("sesion");
    }
 	
?>