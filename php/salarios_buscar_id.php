<?php
    session_start();
	include('../models/Salarios.php');

    $id=$_REQUEST['id'];

    $modeloSalarios = new Salarios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloSalarios->buscarSalariosId($id);
    }else{
        echo json_encode("sesion");
    }
 	
?>