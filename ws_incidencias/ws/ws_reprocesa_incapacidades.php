<?php
	//--- Inicia Encabezado para conexion Mysql (sustituirlo por include proximamente)
	$link = mysqli_connect("192.168.0.166", "root", "denk3n!.", "ginthercorp");

	mysqli_set_charset($link,'utf8');
	//---Finaliza
		
	$query = "CALL repro_incapacidad()";
	$result = mysqli_query($link,$query);
//	if($result)
//		echo 1;
//	else
//		echo "No se pudieron reprocesar las incapacidades";	
//		 
//	}
	 
?>
