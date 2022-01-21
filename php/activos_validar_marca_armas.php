<?php
    session_start();
	  include('../models/Activos.php');

    $marcaArmas = $_REQUEST['marcaArmas'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){
      echo $resultado = $modeloActivos->validarMarcaArmas($marcaArmas);
    }
    else{
      echo json_encode("sesion");
    }


?>
