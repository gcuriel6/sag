<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$sucursal = $_REQUEST["sucursal"];
	
	$arreglo = array();
	
	$query = "SELECT a.* FROM deptos a 
	WHERE a.id_compania = '".$sucursal."' GROUP BY a.id_depto ORDER BY a.des_dep";
	$result=mysqli_query($link,$query);
	$num = mysqli_num_rows($result);
	
	$arreglo[0]= $num;
	
	while($row = mysqli_fetch_array($result))
	{
		$arreglo[] = array('id_depto'=>$row['id_depto'],'cve_dep'=>$row['cve_dep'],'des_dep'=>$row['des_dep'],'servicio'=>$row['servicio'],'inactivo'=>$row['inactivo'],'presupuesto'=>$row['presupuesto']);
	}
	echo json_encode($arreglo);
?>