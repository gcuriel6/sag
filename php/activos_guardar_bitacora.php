<?php
    session_start();
	  include('../models/Activos.php');

    $tipo = $_REQUEST['tipo'];
    $descripcion = $_REQUEST['descripcion'];
    $kilometraje = $_REQUEST['kilometraje'];
    $id = $_REQUEST['id'];

    $modeloActivos = new Activos();
    if (isset($_SESSION['usuario'])){

      echo $resultado = $modeloActivos->guardarBitacora($tipo, $descripcion, $kilometraje, $id);
    }else{
        echo json_encode("sesion");
    }

?>
