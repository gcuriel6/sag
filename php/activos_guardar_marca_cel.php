<?php
    session_start();
	  include('../models/Activos.php');

    $marcaCel = $_REQUEST['marcaCel'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->guardarMarcaCel($marcaCel);
    }else{
        echo json_encode("sesion");
    }


?>
