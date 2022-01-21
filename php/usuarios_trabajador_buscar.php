<?php
    session_start();

	include('../models/Usuarios.php');

    $idUsuario = $_REQUEST['idUsuario'];
    
    $modeloUsuarios = new Usuarios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuarios->buscarTrabajadorUsuario($idUsuario);
    }else{
        echo json_encode("sesion");
    }
 	
?>