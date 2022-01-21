<?php
    session_start();
    include('../models/CargarDatos.php');
    
    $idProveedor = $_REQUEST['idProveedor'];
    $folioOc = $_REQUEST['folioOc'];
    $folioEntrada = $_REQUEST['folioEntrada'];

    $modeloCargarDatos = new CargarDatos();

    if (isset($_SESSION['usuarioP'])){

        echo $resultado = $modeloCargarDatos->guardarCargarDatos($idProveedor,$folioOc,$folioEntrada);
    }else{
        echo json_encode("sesion");
    }
 	
?>