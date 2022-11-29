<?php
    session_start();
    include('../models/Cotizaciones.php');
    
    $idCotiz=$_POST['idCotiz'];
    $comentario=$_POST['comentario'];

    $modeloCotizaciones = new Cotizaciones();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloCotizaciones->guardarCotizacionesCuentaComentarios($idCotiz, $comentario);
    }else{
        echo json_encode("sesion");
    }
 	
?>