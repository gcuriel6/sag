<?php
    session_start();
	include('../models/Viaticos.php');

    $idsSucursal = $_REQUEST['idsSucursal'];
    $busqueda = $_REQUEST['busqueda'];

    $modeloViaticos = new Viaticos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloViaticos->buscarViaticos($idsSucursal,$busqueda);
    }else{
        echo json_encode("sesion");
    }
 	
?>