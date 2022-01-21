<?php

	header('Content-Type: charset=utf-8');
	include '../../php/conectar.php';
	$link = Conectarse();

	session_start();
	
	$registro = $_REQUEST['registro'];
	$validado = $_REQUEST['validado'];
	$usuario = $_SESSION["usuario"];
	
	$query = "UPDATE incidencias2 SET fecha_validacion = NOW(), validado = '$validado', usuario_valido='$usuario' WHERE registro = '$registro' ";
	$resultado = mysqli_query($link,$query);

	if($resultado){
		echo 1;
	}
	else{
		echo 0;
	}
	
?>