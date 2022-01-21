<?php
    session_start();
	include('../models/UnidadesNegocio.php');

    $tipo_mov = $_REQUEST['tipo_mov'];
    $idUnidadesNegocio = $_REQUEST['idUnidadesNegocio'];
    $clave = $_REQUEST['clave'];
    $nombre = $_REQUEST['nombre'];
    $descripcion = $_REQUEST['descripcion'];
    $inactivo = $_REQUEST['inactivo'];
    $elementos = $_REQUEST['elementos'];
    $nombreAnteriorImg = $_REQUEST['nombreAnteriorImg'];

    $modeloUnidadNegocio = new UnidadesNegocio();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloUnidadNegocio->guardarUnidadesNegocio($tipo_mov,$idUnidadesNegocio,$clave,$nombre,$descripcion,$inactivo,$elementos,$nombreAnteriorImg);
    }else{
        echo json_encode("sesion");
    }
 	
?>