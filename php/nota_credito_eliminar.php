<?php
    session_start();
    include('../models/NotasCredito.php');
    
    $id = $_REQUEST['id'];

    $modeloNotasCredito = new NotasCredito();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloNotasCredito->eliminarNotaCredito($id);
    }else{
        echo json_encode("sesion");
    }
 	
?>