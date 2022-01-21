<?php

	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_registro = $_REQUEST["id_registro"];
	
	$query = "DELETE FROM horarios WHERE id_registro = $id_registro";
	$result=mysqli_query($link, $query);
	
	if($result)
		echo 1;
	else {
		echo mysqli_error();
	}
?>