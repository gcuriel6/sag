<?php
    session_start();
    include('../models/Finanzas.php');
    
    $datos = $_REQUEST['datos'];

    $modeloFinanzas = new Finanzas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloFinanzas->guardarVerificadoIdFactura($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>