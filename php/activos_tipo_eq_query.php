<?php
    session_start();
	  include('../models/Activos.php');

    $id = $_REQUEST['id'];

    $modeloActivos = new Activos();

    if (isset($_SESSION['usuario'])){
        echo $resultado = $modeloActivos->queryTipoEqComp($id);
    }else{
        echo json_encode("sesion");
    }

?>
