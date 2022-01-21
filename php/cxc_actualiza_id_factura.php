<?php
    session_start();
    include('../models/CxC.php');

    $datos = $_REQUEST['datos'];
    
    $idFactura = $datos['idFactura'];
    $estatus = $datos['estatus'];
    $registrosCXC = $datos['registrosCXC'];
    $idServicio = $datos['idServicio'];
    $idsServicios = (isset($datos['idsServicios']))?$datos['idsServicios']:'';
    $tipo = $datos['tipo'];

    $modeloCxC = new CxC();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxC->actualizaCXCIDFactura($idFactura,$estatus,$tipo,$registrosCXC,$idServicio,$idsServicios);
    }else{
        echo json_encode("sesion");
    }
 	
?>