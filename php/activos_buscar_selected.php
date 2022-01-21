<?php
    session_start();
	  include('../models/Activos.php');

    $idActivo = $_REQUEST['idActivo'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario']))
    {
        $_SESSION['id_activo'] = $idActivo;
        echo $resultado = $modeloActivos->buscarActivoSelected($idActivo);
    }
    else
        echo json_encode("sesion");

?>
