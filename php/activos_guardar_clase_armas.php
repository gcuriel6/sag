<?php
    session_start();
	  include('../models/Activos.php');

    $claseArmas = $_REQUEST['claseArmas'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->guardarClaseArmas($claseArmas);
    }else{
        echo json_encode("sesion");
    }


?>
