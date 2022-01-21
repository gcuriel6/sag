<?php
    session_start();
	include('../models/Firmantes.php');

    $tipo_mov = $_REQUEST['tipo_mov'];
    $idFirmante = $_REQUEST['idFirmante'];
    $email = $_REQUEST['email'];
    $nombre = $_REQUEST['nombre'];
    $telefono = $_REQUEST['telefono'];
    $inactivo = $_REQUEST['inactivo'];
    $iniciales = $_REQUEST['iniciales'];
    $imagenAnterior = $_REQUEST['imagenAnterior'];
    $elementos = $_REQUEST['elementos'];

    $modeloFirmantes = new Firmantes();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloFirmantes->guardarFirmantes($tipo_mov,$idFirmante,$nombre,$email,$telefono,$iniciales,$inactivo,$imagenAnterior,$elementos);
    }else{
        echo json_encode("sesion");
    }
 	
?>