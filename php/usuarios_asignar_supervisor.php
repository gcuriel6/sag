<?php
    session_start();
	include('../models/Usuarios.php');

    $idUsuario = $_REQUEST['idUsuario'];
    $idSupervisor = $_REQUEST['idSupervisor'];
   
    $modeloUsuarios = new Usuarios();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloUsuarios->asignarSupervisorUsuarios($idUsuario,$idSupervisor);
    }else{
        echo json_encode("sesion");
    }
 	
?>