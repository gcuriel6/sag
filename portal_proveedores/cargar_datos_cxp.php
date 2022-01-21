<?php
    session_start();
	include('../models/CargarDatos.php');

    $idProveedor = $_REQUEST['idProveedor'];
    $idE01 = $_REQUEST['idE01'];
    $fechaVencimiento = $_REQUEST['fechaVencimiento'];
    $folioOc = $_REQUEST['folioOc'];
    $folioEntrada = $_REQUEST['folioEntrada'];

    $modeloCargarDatos = new CargarDatos();

    if (isset($_SESSION['usuarioP'])){

        echo $resultado = $modeloCargarDatos->generarCXP($idProveedor,$idE01,$fechaVencimiento,$folioOc,$folioEntrada);
    }else{
        echo json_encode("sesion");
    }
 	
?>