<?php
    session_start();

	include('../models/Usuarios.php');

    $usuario = $_REQUEST['usuario'];
    
    $modeloUsuarios = new Usuarios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuarios->verificarUsuarios($usuario);
    }else{
        echo json_encode("sesion");
    }
 	
?>