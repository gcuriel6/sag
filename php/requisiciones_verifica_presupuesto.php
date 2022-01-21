<?php
    session_start();
	include('../models/Requisiciones.php');

    $idFamilia=$_REQUEST['idFamilia'];
    $idUnidad=$_REQUEST['idUnidad'];
    $idSucursal=$_REQUEST['idSucursal'];
    //-->NJES June/16/2020 DEN18-2769 Modificar la validación de presupuesto en el modulo de requisiciones
    //$idArea=$_REQUEST['idArea'];
    //$idDepto=$_REQUEST['idDepto'];

    $modeloRequisiciones = new Requisiciones();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRequisiciones->buscarRequisicionesPresupuesto($idFamilia,$idUnidad,$idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>