<?php
    session_start();
	include('../models/Contratos.php');

   
    $idContrato = $_REQUEST['idContrato'];
    $tipoContrato = $_REQUEST['tipoContrato'];
    $elementos = $_REQUEST['elementos'];

    $modeloContratos = new Contratos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloContratos->guardarArchivoContrato($idContrato,$tipoContrato,$elementos);
    }else{
        echo json_encode("sesion");
    }
 	
?>