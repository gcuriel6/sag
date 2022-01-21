<?php
    session_start();
    include('../models/CxCAlarmas.php');
    
    $datos = $_REQUEST['datos'];

    $modeloCxCAlarmas = new CxCAlarmas();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCxCAlarmas->guardarCxC($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>