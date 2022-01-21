<?php
    session_start();
	include('../models/CargarDatos.php');

    $idProveedor = $_REQUEST['idProveedor'];
    $idE01 = $_REQUEST['idE01'];
    $fechaVencimiento = $_REQUEST['fechaVencimiento'];
    $folioOc = $_REQUEST['folioOc'];
    $folioEntrada = $_REQUEST['folioEntrada'];
    //-->NJES Jan/30/2020 enviamos el id de la orden de compra para poder buscar sus requisiciones de anticipo y ver si ya existen cxp de esas requisiciones
    $idOC = $_REQUEST['idOC'];

    $modeloCargarDatos = new CargarDatos();

    if (isset($_SESSION['usuarioP'])){

        echo $resultado = $modeloCargarDatos->guardarCXP($idProveedor,$idE01,$fechaVencimiento,$folioOc,$folioEntrada,$idOC);
    }else{
        echo json_encode("sesion");
    }
 	
?>