<?php
	include '../../php/conectar.php';

	$link = Conectarse();
	
	$parametro = $_REQUEST["parametro"];
	$valor = $_REQUEST["valor"];
	
	$arreglo = array();
	if($parametro=='id')
		$query = "SELECT a.*,b.cve_dep,b.des_dep,c.descr as sucursal,IFNULL(d.sueldo,'-') as sueldo 
					FROM trabajadores a 
					LEFT JOIN deptos b ON a.id_depto = b.id_depto 
					LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
					LEFT JOIN salarios d ON a.id_trabajador = d.id_trabajador AND d.activo = 1
					WHERE a.id_trabajador = '".$valor."'";
	else if($parametro=='nombre')
		$query = "SELECT a.*,b.cve_dep,b.des_dep,c.descr as sucursal 
					FROM trabajadores a 
					LEFT JOIN deptos b ON a.id_depto = b.id_depto 
					LEFT JOIN sucursales c ON a.id_sucursal = c.id_sucursal
					WHERE a.nombre LIKE '".$valor."%' OR a.apellido_p LIKE '".$valor."%' OR a.apellido_m LIKE '".$valor."%'";
	

	$result=mysqli_query($link,$query);
	$num = mysqli_num_rows($result);
	
	$arreglo[0]= $num;
	while($row=mysqli_fetch_array($result)){
	
		$arreglo[] = array('id_empleado'=>$row['id_trabajador'],'nombre'=>$row['nombre'],'apellido_p'=>$row['apellido_p'],'apellido_m'=>$row['apellido_m'],'id_depto'=>$row['id_depto'],'cve_dep'=>$row['cve_dep'],'des_dep'=>$row['des_dep'],'id_sucursal'=>$row['id_sucursal'],'sucursal'=>$row['sucursal'],'fecha_ingreso'=>$row['fecha_ingreso'],'fecha_baja'=>$row['fecha_baja'],'sueldo'=>$row['sueldo']);
	}
	echo json_encode($arreglo);
?>