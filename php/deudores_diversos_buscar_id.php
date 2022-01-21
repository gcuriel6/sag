<?php

    session_start();
    include('../models/DeudoresDiversos.php');

    $id = $_REQUEST['id'];
    
    $modeloDeudoresDiversos = new DeudoresDiversos();

    if (isset($_SESSION['usuario']))
        echo $resultado = $modeloDeudoresDiversos->buscarDeudoresDiversosId($id);
    else
        echo json_encode("sesion");
 	
?>