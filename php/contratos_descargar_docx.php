<?php
    session_start();
	include('../widgets/WordContratos.php');

    $idContrato=$_REQUEST['idContrato'];
    $tipoContrato=$_REQUEST['tipoContrato'];

    $modeloWordContratos = new WordContratos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloWordContratos->descargarContrato($idContrato,$tipoContrato);
    }else{
        echo json_encode("sesion");
    }
 	
?>