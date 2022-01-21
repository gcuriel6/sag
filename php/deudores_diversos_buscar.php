<?php

    session_start();
    include('../models/DeudoresDiversos.php');
    
    $modeloDeudoresDiversos = new DeudoresDiversos();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloDeudoresDiversos->buscarDeudoresDiversos();
    else
        echo json_encode("sesion");
 	
?>