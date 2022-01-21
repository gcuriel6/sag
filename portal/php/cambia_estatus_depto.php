<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_depto = $_REQUEST["id_depto"];
	$opcion = $_REQUEST["opcion"];
	
	$query = "UPDATE deptos SET inactivo = $opcion WHERE id_depto = $id_depto";
	$result=mysqli_query($link,$query);
	
	if($result)
		echo 1;
	else {
		echo mysqli_error();
	}
?>