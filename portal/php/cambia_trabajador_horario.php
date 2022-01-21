<?php
	include '../../php/conectar.php';
	include("time.php");
	$link = Conectarse();
	
	$id_depto = $_REQUEST["id_depto"];
	$id_empleado_ant = $_REQUEST["id_trab1"];
	$difvacante = $_REQUEST["difvacante"];
	$id_empleado_nue = $_REQUEST["id_trab2"];
	$fecha =  obtieneDate($link);
	
	
	$query = "UPDATE horarios SET id_empleado = $id_empleado_nue, difvacante = 0, cambio = 1 
	WHERE id_depto = $id_depto  AND id_empleado = $id_empleado_ant AND difvacante = $difvacante";
	
	$result=mysqli_query($link,$query);
	
	if($result)
		echo 1;
	else {
		echo mysqli_error();
	}
	 
?>