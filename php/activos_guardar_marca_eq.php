<?php
    session_start();
	  include('../models/Activos.php');

    $marcaEq = $_REQUEST['marcaEq'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->guardarMarcaEq($marcaEq);
    }else{
        echo json_encode("sesion");
    }

?>
