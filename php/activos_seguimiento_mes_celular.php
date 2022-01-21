<?php
    session_start();
	  include('../models/Activos.php');

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->activosSeguimientoMesCelular();
    }else{
        echo json_encode("sesion");
    }

?>
