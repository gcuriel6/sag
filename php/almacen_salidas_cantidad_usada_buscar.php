<?php
    session_start();
	include('../models/SalidasAlmacen.php');

    $id =$_REQUEST['idSalida'];
    
    $modeloSalidasAlmacen = new SalidasAlmacen();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloSalidasAlmacen->buscarCantidadActualSalida($id);
    }else{
        echo json_encode("sesion");
    }
 	
?>