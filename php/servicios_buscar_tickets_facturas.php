<?php
    session_start();
	include('../models/Servicios.php');

    $idFactura=$_REQUEST['idFactura'];

    $modeloCliente = new Servicios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCliente->buscaTicketsIdFactura($idFactura);
    }else{
        echo json_encode("sesion");
    }
 	
?>