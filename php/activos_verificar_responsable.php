<?php
    session_start();
	  include('../models/Activos.php');

    $activo = $_REQUEST['activo'];

    $modeloActivos = new Activos();
    if (isset($_SESSION['usuario'])){

      echo $resultado = $modeloActivos->verificarResponsable($activo);
    }else{
        echo json_encode("sesion");
    }

?>
