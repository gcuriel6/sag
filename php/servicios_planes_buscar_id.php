<?php
    session_start();
    include('../models/Servicios.php');
    
    $idBitacoraPlan = $_REQUEST['idBitacoraPlan'];
    $idCXC = $_REQUEST['idCXC'];

    $modeloServicios = new Servicios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloServicios->buscarServiciosPlanesId($idBitacoraPlan,$idCXC);
    }else{
        echo json_encode("sesion");
    }
 	
?>