<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_empleado = $_REQUEST["id_empleado"];
	$difvacante = $_REQUEST["difvacante"];
	$id_depto = $_REQUEST["id_depto"];
	
	
	$query = "SELECT b.puesto,a.id_puesto,a.descr,a.id_registro,a.fechadia1,a.horas,
trim(concat(dia1,dia2,dia3,dia4,dia5,dia6,dia7,dia8,dia9,dia10,dia11,dia12,dia13,dia14,dia15,dia16,dia17,dia18,dia19,dia20,dia21,dia22,dia23,dia24,dia25,dia26,dia27,dia28,dia29,dia30,dia31)) AS cadena 
FROM horarios a LEFT JOIN cat_puestos b ON a.id_puesto = b.id_puesto WHERE a.id_empleado = $id_empleado AND difvacante = $difvacante AND id_depto = $id_depto";
	$result=mysqli_query($link,$query);
	$num = mysqli_num_rows($result);
	
	$row = mysqli_fetch_array($result);
	$tam = strlen($row['cadena']);
	$arreglo = array('id_registro'=>$row['id_registro'],'puesto'=>$row['puesto'],'id_puesto'=>$row['id_puesto'],'horas'=>$row['horas'],'descr'=>$row['descr'],'cadena'=>$row['cadena'],'dias'=>$tam,'fechadia1'=>$row['fechadia1']);
	
	echo json_encode($arreglo);
?>