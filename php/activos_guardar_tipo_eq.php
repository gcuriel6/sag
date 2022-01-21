<?php
    session_start();
	  include('../models/Activos.php');

    $tipoEq = $_REQUEST['tipoEq'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->guardarTipoEq($tipoEq);
    }else{
        echo json_encode("sesion");
    }

?>
