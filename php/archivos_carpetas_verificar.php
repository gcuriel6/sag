<?php
    session_start();
	include('../models/Archivos.php');

    $datos=$_REQUEST['datos'];
    $tipo = $datos['tipo'];
    
    $modeloArchivos = new Archivos();

    if (isset($_SESSION['usuario'])){
        if($tipo == 'carpeta')
            echo $resultado = $modeloArchivos->verificaCarpetaNombre($datos);
        else 
            echo $resultado = $modeloArchivos->verificaDescripcionArchivo($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>