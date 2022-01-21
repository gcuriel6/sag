<?php		
	header('Content-Type: charset=utf-8');
	include 'conectar.php';
	$link = Conectarse();
	
	$registro = $_REQUEST['registro'];
	
	$query = 'SELECT id_depto FROM presupuesto WHERE registro = '.$registro;
	$result = mysql_query($query,$link);
	$row = mysql_fetch_array($result);
	$id_depto = $row['id_depto'];

	$query = 'DELETE FROM presupuesto WHERE registro = '.$registro;
	$resultado = mysql_query($query,$link);

	if($resultado){
		echo $id_depto;
	}
	else{
		echo 0;
	}
	
?>