<?php
    session_start();
	include('../models/Gastos.php');

    $idGasto=$_REQUEST['idGasto'];

    $modeloGastos = new Gastos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloGastos->buscarDetallesGastosId($idGasto);
    }else{
        echo json_encode("sesion");
    }
 	
?>