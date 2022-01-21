<?php
    session_start();
	  include('../models/Activos.php');

    $idActivo = $_REQUEST['idActivo'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->buscarActivoSelectedResponsable($idActivo);
    }else{
        echo json_encode("sesion");
    }

?>
