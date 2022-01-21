<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$valor = $_REQUEST["valor"];
	
	$arreglo = array();
	
	$query = "SELECT a.*,b.des_dep,c.descr as sucursal FROM trabajadores a LEFT JOIN deptos b ON a.id_depto = b.id_depto 
	LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
	WHERE fecha_baja = '0000-00-00' AND  (a.nombre LIKE '".$valor."%' OR a.apellido_p LIKE '".$valor."%' OR a.apellido_m LIKE '".$valor."%')";
	
	
	$result=mysqli_query($link,$query);
	$num = mysqli_num_rows($result);
	
	$arreglo[0]= $num;
	while($row=mysqli_fetch_array($result)){
	
		$arreglo[] = array('id_empleado'=>$row['id_trabajador'],'nombre'=>trim($row['nombre']),'apellido_p'=>trim($row['apellido_p']),'apellido_m'=>trim($row['apellido_m']),'id_depto'=>$row['id_depto'],'des_dep'=>$row['des_dep'],'id_sucursal'=>$row['id_sucursal'],'sucursal'=>$row['sucursal'],'fecha_ingreso'=>$row['fecha_ingreso'],'fecha_baja'=>$row['fecha_baja'],'sueldo'=>$row['sueldo']);
	}
	echo json_encode($arreglo);
?>