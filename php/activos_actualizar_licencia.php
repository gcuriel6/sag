<?php
    session_start();
	  include('../models/Activos.php');

    $no_lic = $_REQUEST['no_lic'];
    $vig_lic = $_REQUEST['vig_lic'];
    $id = $_REQUEST['id'];
    $id_activo = $_REQUEST['id_activo'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->actualizarLicenciaSeguimiento($no_lic, $vig_lic, $id, $id_activo);
    }else{
        echo json_encode("sesion");
    }

?>
