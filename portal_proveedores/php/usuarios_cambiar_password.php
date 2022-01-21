<?php
    session_start();
	include('../models/Usuarios.php');

    $idUsuario=$_REQUEST['idUsuario'];
    $contra=sha1($_REQUEST['contra']);

    $modeloUsuario = new Usuarios();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->cambiarPasswordUsuarios($idUsuario,$contra);
    }else{
        echo json_encode("sesion");
    }
 	
?>