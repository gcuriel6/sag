<?php
   
	include('../models/Usuarios.php');

    $datos = $_REQUEST['datos'];
   
    $modeloUsuarios = new Usuarios();

    echo $resultado = $modeloUsuarios->guardarUsuarios($datos);
   
 	
?>