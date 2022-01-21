<?php		
	header('Content-Type: charset=utf-8');
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$registros = $_REQUEST['registros'];
	
	$query = 'UPDATE incidencias2 SET fecha_validacion = NOW(), validado = 1 WHERE registro IN '.$registros.' ';
	$resultado = mysqli_query($link,$query);

	if($resultado){
		echo 1;
	}
	else{
		echo 0;
	}
	
?>