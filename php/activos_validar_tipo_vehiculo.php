<?php
    session_start();
	  include('../models/Activos.php');

    $tipoVeh = $_REQUEST['tipoVeh'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){
      echo $resultado = $modeloActivos->validarTipoVeh($tipoVeh);
    }
    else{
      echo json_encode("sesion");
    }


?>
