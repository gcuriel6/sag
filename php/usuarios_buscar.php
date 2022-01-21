<?php
    session_start();
	include('../models/Usuarios.php');

    $estatus=$_REQUEST['estatus'];

    $modeloUsuario = new Usuarios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarUsuarios($estatus);
    }else{
        echo json_encode("sesion");
    }
 	
?>