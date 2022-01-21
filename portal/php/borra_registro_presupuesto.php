<?php		
	header('Content-Type: charset=utf-8');
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$registro = $_REQUEST['registro'];
	
	$query = 'SELECT id_depto FROM presupuesto WHERE registro = '.$registro;
	$result = mysqli_query($link,$query);
	$row = mysqli_fetch_array($result);
	$id_depto = $row['id_depto'];

	$query = 'DELETE FROM presupuesto WHERE registro = '.$registro;
	$resultado = mysqli_query($link,$query);

	if($resultado){
		echo $id_depto;
	}
	else{
		echo 0;
	}
	
?>