<?php
    session_start();
    include('../models/Finanzas.php');
    
    $datos = $_REQUEST['datos'];

    $modeloFinanzas = new Finanzas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFinanzas->buscarDashFinanzas($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>