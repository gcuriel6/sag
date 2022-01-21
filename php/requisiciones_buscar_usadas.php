<?php
    session_start();
	include('../models/Requisiciones.php');

    $idsRequisiciones = $_REQUEST['idsRequis'];

    $modeloRequisiciones = new Requisiciones();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloRequisiciones->buscarRequisicionUsadas($idsRequisiciones);
    }else{
        echo json_encode("sesion");
    }
 	
?>