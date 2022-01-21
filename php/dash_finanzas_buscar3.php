<?php
    session_start();
    include('../models/Finanzas.php');
    
    $datos = $_REQUEST['datos'];

    // print_r($datos);
    // exit();

    $modeloFinanzas = new Finanzas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFinanzas->buscarDashFinanzas3($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>