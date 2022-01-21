<?php
    session_start();
	include('../models/Gastos.php');

    $id = $_REQUEST['id'];
   
    $modeloGastos = new Gastos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloGastos->guardarOmitirRequisicion($id);
    }else{
        echo json_encode("sesion");
    }
 	
?>