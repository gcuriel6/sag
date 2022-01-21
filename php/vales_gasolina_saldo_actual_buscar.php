<?php
    session_start();
    include('../models/ValesGasolina.php');
    
    $idSucursal = $_REQUEST['idSucursal'];

    $modeloValesGasolina = new ValesGasolina();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloValesGasolina->buscarSaldoActualIdSucursal($idSucursal);
    }else{
        echo json_encode("sesion");
    }
 	
?>