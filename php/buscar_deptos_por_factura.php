<?php

    session_start();

    include('../models/Departamentos.php');

    $idFactura = $_REQUEST['idFactura'];

    $modelDeptos = new Departamentos();

    if (isset($_SESSION['usuario']))
          echo $modelDeptos->buscarDeptosPorFactura($idFactura);
    else
        echo json_encode("sesion");
 	
?>