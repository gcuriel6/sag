<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_empleado = $_REQUEST["id_empleado"];
	
	$query = "SELECT a.*,b.cve_dep,b.des_dep 
				FROM incidencias2 a 
				LEFT JOIN deptos b ON a.id_depto = b.id_depto 
				WHERE ano = YEAR(CURDATE()) AND a.id_empleado = $id_empleado ";
	$result=mysqli_query($link,$query);
	$num = mysqli_num_rows($result);
	$arreglo[0]=$num;
	
	while($row = mysqli_fetch_array($result)){
		$tam = strlen($row['cadena']);
		$arreglo[] = array('cve_dep'=>$row['cve_dep'],'des_dep'=>$row['des_dep'],'id_depto'=>$row['id_depto'],'incidencia'=>$row['incidencia'],'incidencia_aux'=>$row['incidencia_aux'],'fecha'=>$row['fecha']);
	}
	
	echo json_encode($arreglo);
?>