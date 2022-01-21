<?php

    session_start();
    include('../models/DeudoresDiversos.php');

    $datos = $_REQUEST['datos'];
    
    $modeloDeudoresDiversos = new DeudoresDiversos();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloDeudoresDiversos->buscarDeudoresDiversosReporte($datos);
    else
        echo json_encode("sesion");
 	
?>