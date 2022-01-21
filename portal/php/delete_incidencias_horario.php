<?php	
	header('Content-Type: charset=utf-8');
	include '../../php/conectar.php';
	include("time.php");
	$link = Conectarse();
	
	$id_registro = $_REQUEST['id_registro'];
	
	
	$query = "SELECT * FROM horarios WHERE id_registro = ".$id_registro;
	
	$resultado = mysqli_query($link,$query);
	$row = mysqli_fetch_array($resultado);
	
	$id_empleado = $row['id_empleado'];
	$difvacante = $row['difvacante'];
	$id_depto = $row['id_depto'];
	
	
	$fecini = obtieneDate($link);
	
	$query_final = "DELETE FROM incidencias2 WHERE fecha >= '".$fecini."' AND id_empleado = $id_empleado AND difvacante = $difvacante AND id_depto = $id_depto";
	
	 
	if($result = mysqli_query($link,$query_final)){
		echo 1;
	}
	else{
		echo mysqli_error();
	}
	
?>