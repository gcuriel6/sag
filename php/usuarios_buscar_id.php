<?php
    session_start();
	include('../models/Usuarios.php');

    $idUsuario=$_REQUEST['idUsuario'];

    $modeloUsuario = new Usuarios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarUsuariosId($idUsuario);
    }else{
        echo json_encode("sesion");
    }
 	
?>