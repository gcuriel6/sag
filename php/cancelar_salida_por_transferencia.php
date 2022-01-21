<?php
    session_start();
	include('../models/SalidasAlmacen.php');

    // print_r($_REQUEST);
    // exit();

    $folio = $_REQUEST['folio'];
    
    $modeloSalidasAlmacen = new SalidasAlmacen();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloSalidasAlmacen->cancelarSalidaTransferencia($folio);
    }else{
        echo json_encode("sesion");
    }
 	
?>