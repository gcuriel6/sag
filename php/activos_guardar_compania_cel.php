<?php
    session_start();
	  include('../models/Activos.php');

    $companiaCel = $_REQUEST['companiaCel'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->guardarCompaniaCel($companiaCel);
    }else{
        echo json_encode("sesion");
    }

?>
