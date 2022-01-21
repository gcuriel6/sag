<?php
    session_start();
	  include('../models/Activos.php');

    $activo = $_REQUEST['activo'];
    $arregloRes = $_REQUEST['arregloRes'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->activosResponsableReasignar($activo, $arregloRes);
    }else{
        echo json_encode("sesion");
    }

?>
