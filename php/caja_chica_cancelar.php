<?php
    session_start();
    include('../models/CajaChica.php');
    
    $idRegistro = $_REQUEST['idRegistro'];

    $modeloCajaChica = new CajaChica();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloCajaChica->cancelarCajaChica($idRegistro);
    }else{
        echo json_encode("sesion");
    }
 	
?>