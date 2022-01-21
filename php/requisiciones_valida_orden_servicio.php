<?php

    session_start();
	include('../models/Requisiciones.php');

    $id = $_REQUEST['id'];

    $requisicion = new Requisiciones();

    if (isset($_SESSION['usuario']))
        echo $resultado = $requisicion->validaOrdenServicio($id);
    else
        echo json_encode("sesion");

?>
