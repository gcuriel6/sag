<?php
    session_start();
	include('../models/Viaticos.php');

    $idViatico=$_REQUEST['idViatico'];

    $modeloViaticos = new Viaticos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloViaticos->imprimirViaticos($idViatico);
    }else{
        echo json_encode("sesion");
    }
 	
?>