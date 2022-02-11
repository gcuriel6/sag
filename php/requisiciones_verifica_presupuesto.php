<?php
    session_start();
	include('../models/Requisiciones.php');

    $idFamilia=$_REQUEST['idFamilia'];
    $idUnidad=$_REQUEST['idUnidad'];
    $idSucursal=$_REQUEST['idSucursal'];
    $idClas=$_REQUEST['idClas'];
    //-->NJES June/16/2020 DEN18-2769 Modificar la validaci�n de presupuesto en el modulo de requisiciones
    //$idArea=$_REQUEST['idArea'];
    //$idDepto=$_REQUEST['idDepto'];

    $modeloRequisiciones = new Requisiciones();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRequisiciones->buscarRequisicionesPresupuesto($idFamilia,$idUnidad,$idSucursal,$idClas);
    }else{
        echo json_encode("sesion");
    }
 	
?>