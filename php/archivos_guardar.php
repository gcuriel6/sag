<?php
    session_start();
	include('../models/Archivos.php');

    $idArea = $_REQUEST['idArea'];
    $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
    $tipo = $_REQUEST['tipo'];
    $descripcion = $_REQUEST['descripcion'];
    $idCarpeta = $_REQUEST['idCarpeta'];
    $nombreCarpeta = $_REQUEST['nombreCarpeta'];

    $datos = array(
        'idArea'=>$idArea,
        'idUnidadNegocio'=>$idUnidadNegocio,
        'tipo'=>$tipo,
        'descripcion'=>$descripcion,
        'idCarpeta'=>$idCarpeta,
        'nombreCarpeta'=>$nombreCarpeta
    ); 
    
    $modeloArchivos = new Archivos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloArchivos->guardar($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>