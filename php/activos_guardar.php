<?php
    session_start();
	  include('../models/Activos.php');

    $datos_generales = $_REQUEST['datos_generales'];

    $modeloActivos = new Activos();
    if (isset($_SESSION['usuario'])){

      echo $resultado = $modeloActivos->guardarDatosGenerales($datos_generales);
    }else{
        echo json_encode("sesion");
    }

?>
