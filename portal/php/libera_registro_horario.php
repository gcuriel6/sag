<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_depto = $_REQUEST["id_depto"];
	$id_empleado_ant = $_REQUEST["id_trab"];
	$fecha = $_REQUEST["fecha"];
	
	$query = "SELECT MAX(difvacante) as difvacante FROM horarios WHERE id_depto = $id_depto AND id_empleado = 0";
	$result=mysqli_query($link,$query);
	
	if($result){
		$row = mysqli_fetch_array($result);
		$difvacante = $row['difvacante'];
		$difvacante = $difvacante +1;
	}
	else {
		$difvacante = 1;
	}
	
	
	
	$query = "UPDATE horarios SET id_empleado = 0, difvacante = $difvacante, cambio = 1 WHERE id_depto = $id_depto  AND id_empleado = $id_empleado_ant";
	//echo $query;
	
	
	$result=mysqli_query($link,$query);
	
	if($result)
		echo 1;
	else {
		echo mysqli_error();
	}
	
	 
?>