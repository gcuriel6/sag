<?php
    session_start();
	include('../models/Almacenes.php');

    $idSucursal = $_REQUEST['id_sucursal'];

    $modeloAlmacen = new Almacenes();

    if (isset($_SESSION['usuario']))
          echo $modeloAlmacen->buscarInventarioSucursal($idSucursal);
    else
        echo json_encode("sesion");
 	
?>