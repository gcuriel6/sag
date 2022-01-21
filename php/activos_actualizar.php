<?php
    session_start();
	  include('../models/Activos.php');

    $datos_generales = $_REQUEST['datos_generales'];
    $id = $_REQUEST['id'];

    $modeloActivos = new Activos();
    if (isset($_SESSION['usuario'])){

      echo $resultado = $modeloActivos->actualizarDatosGenerales($datos_generales, $id);
    }else{
        echo json_encode("sesion");
    }

?>
