<?php
    session_start();
	include('../models/Departamentos.php');

    $estatus=$_REQUEST['estatus'];

    $modeloUsuario = new Departamentos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarDepartamentos($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>