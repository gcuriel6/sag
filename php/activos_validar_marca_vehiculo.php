<?php
    session_start();
	  include('../models/Activos.php');

    $marcaVeh = $_REQUEST['marcaVeh'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){
      echo $resultado = $modeloActivos->validarMarcaVeh($marcaVeh);
    }
    else{
      echo json_encode("sesion");
    }


?>
