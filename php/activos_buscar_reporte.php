<?php
    session_start();
	  include('../models/Activos.php');

    $idUnidadNegocio = $_REQUEST['idUnidadNegocio']; 
    $idSucursal = $_REQUEST['idSucursal'];
    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin'];
    $idEmpresaFiscal = isset($_REQUEST['idEmpresaFiscal']) ? $_REQUEST['idEmpresaFiscal'] : '';

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->buscarReporteActivos($idUnidadNegocio,$idSucursal,$fechaInicio,$fechaFin,$idEmpresaFiscal);
    }else{
        echo json_encode("sesion");
    }

?>
