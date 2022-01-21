<?php
    session_start();
	  include('../models/Activos.php');

    $idResponsable = $_REQUEST['idResponsable'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->devolverActivoSelectedResponsable($idResponsable);
    }else{
        echo json_encode("sesion");
    }

?>
