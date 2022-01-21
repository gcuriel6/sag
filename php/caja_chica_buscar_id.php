<?php
    session_start();
    include('../models/CajaChica.php');
    
    $idCajaChica = $_REQUEST['idCajaChica'];

    $modeloCajaChica = new CajaChica();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloCajaChica->buscarCajaChicaId($idCajaChica);
    }else{
        echo json_encode("sesion");
    }
 	
?>