<?php
    session_start();
	include('../models/SalidasAlmacen.php');

    $idSalida = $_REQUEST['idSalida'];
    
    $modeloSalidasAlmacen = new SalidasAlmacen();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloSalidasAlmacen->buscarDetalleSalidasId($idSalida);
    }else{
        echo json_encode("sesion");
    }
 	
?>