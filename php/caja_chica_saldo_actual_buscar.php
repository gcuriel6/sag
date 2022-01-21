<?php
    session_start();
    include('../models/CajaChica.php');
    
    $idSucursal = $_REQUEST['idSucursal'];

    $modeloCajaChica = new CajaChica();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCajaChica->buscarSaldoActualIdSucursal($idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>