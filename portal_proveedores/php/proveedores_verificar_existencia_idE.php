<?php
    session_start();
	include('../models/CargarDatos.php');

    $idE01 = $_REQUEST['idE01'];

    $modeloCargarDatos = new CargarDatos();

    if (isset($_SESSION['usuarioP'])){

        echo $resultado = $modeloCargarDatos->verificaExistenciaEA($idE01);
    }else{
        echo json_encode("sesion");
    }
 	
?>