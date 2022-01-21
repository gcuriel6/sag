<?php
    session_start();
	include('../models/Viaticos.php');

    $idViatico=$_REQUEST['idViatico'];

    $modeloViaticos = new Viaticos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloViaticos->buscarViaticosId($idViatico);
    }else{
        echo json_encode("sesion");
    }
 	
?>