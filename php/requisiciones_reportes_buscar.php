<?php
    session_start();
    include('../models/Requisiciones.php');
    
    $datos = $_REQUEST['datos'];

    $modelRequisiciones = new Requisiciones();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modelRequisiciones->buscarRequisicionesReportes($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>