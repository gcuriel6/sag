<?php

    session_start();

    include('../models/Departamentos.php');

    $idSucursal = $_REQUEST['idSuc'];

    $modelDeptos = new Departamentos();

    if (isset($_SESSION['usuario']))
          echo $modelDeptos->buscarDeptosPorSucursal($idSucursal);
    else
        echo json_encode("sesion");
 	
?>