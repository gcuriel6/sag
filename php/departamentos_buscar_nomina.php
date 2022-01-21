<?php
    session_start();
	include('../models/Departamentos.php');

    $modeloUsuario = new Departamentos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarDepartamentosNomina();
    }else{
        echo json_encode("sesion");
    }
 	
?>