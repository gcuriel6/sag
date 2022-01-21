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
	$id_depto = $row['id_depto'];
	
	$query = "SELECT MAX(difvacante) as difvacante FROM horarios WHERE id_depto = $id_depto AND id_empleado = 0";
	$result=mysqli_query($link,$query);
	
	if($result){
		
		$row = mysqli_fetch_array($result);
		$difvacante = $row['difvacante'];
		
		$difvacante ++;
	}
	else {
		
		$difvacante = 1;
	}
	
	$fecini = obtieneDate($link);
	
	$query_final = "UPDATE incidencias2 SET id_empleado = 0, difvacante = $difvacante, incidencia_aux = '', incidencia_vta = ''  WHERE fecha >= '".$fecini."' AND id_empleado = $id_empleado AND id_depto = $id_depto";
	
	//echo $query_final;
	if($result = mysqli_query($link,$query_final)){
		echo 1;
	}
	else{
		echo mysqli_error();
	}
?>