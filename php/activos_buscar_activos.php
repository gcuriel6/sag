<?php
    session_start();
      include('../models/Activos.php');
      
    $datos = $_REQUEST['datos'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloActivos->buscarActivos($datos);
    }else{
        echo json_encode("sesion");
    }

?>
