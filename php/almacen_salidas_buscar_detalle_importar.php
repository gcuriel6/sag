<?php
    session_start();
	include('../models/SalidasAlmacen.php');

    $id =$_REQUEST['id'];
    
    $modeloSalidasAlmacen = new SalidasAlmacen();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloSalidasAlmacen->buscarSalidasTransaccionesDetalleImportar($id);
    }else{
        echo json_encode("sesion");
    }
 	
?>