<?php
    session_start();
    include('../models/CxC.php');
    
    $datos = $_REQUEST['datos'];

    $modeloCxC = new CxC();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCxC->buscarRegistroInicial($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>