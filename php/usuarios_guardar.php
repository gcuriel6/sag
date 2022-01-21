<?php
    session_start();
	include('../models/Usuarios.php');

    $datos = $_REQUEST['datos'];
   
    $modeloUsuarios = new Usuarios();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloUsuarios->guardarUsuarios($datos);
    }else{
        echo json_encode("sesion");
    }
 	
?>