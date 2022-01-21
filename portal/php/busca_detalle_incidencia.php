<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$registro = $_REQUEST["registro"];
	
	
	
	$query = "SELECT a.registro,a.id_empleado,a.evento as tipo,a.facturable as cobro,IF(ISNULL(a1.nombre),'VACANTE',CONCAT(TRIM(a1.nombre),' ',TRIM(a1.apellido_p),' ',TRIM(a1.apellido_m))) as nombre,
				CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p),' ',TRIM(b.apellido_m)) as nom_reem1,reem1,incidencia1,
				CONCAT(TRIM(c.nombre),' ',TRIM(c.apellido_p),' ',TRIM(b.apellido_m)) as nom_reem2,reem2,incidencia2,
				CONCAT(TRIM(d.nombre),' ',TRIM(d.apellido_p),' ',TRIM(b.apellido_m)) as nom_reem3,reem3,incidencia3,
				a.justificacion,if(a.incidencia_aux='',a.incidencia,a.incidencia_aux) as incidencia,a.fecha
				FROM incidencias2 a
				LEFT JOIN trabajadores a1 ON a.id_empleado=a1.id_trabajador 
				LEFT JOIN trabajadores b ON a.reem1 = b.id_trabajador  
				LEFT JOIN trabajadores c ON a.reem2 = c.id_trabajador
				LEFT JOIN trabajadores d ON a.reem3 = d.id_trabajador
				WHERE a.registro = $registro";
					$result=mysqli_query($link,$query);
	
	$row = mysqli_fetch_array($result);
	
	$arreglo = array('registro'=>$row['registro'],'id_empleado'=>$row['id_empleado'],'justificacion'=>$row['justificacion'],
	'tipo'=>$row['tipo'],'cobro'=>$row['cobro'],'nombre_empleado'=>$row['nombre'],'incidencia'=>$row['incidencia'],
	'fecha'=>$row['fecha'],
	'nom_reem1'=>$row['nom_reem1'],'reem1'=>$row['reem1'],'incidencia1'=>$row['incidencia1'],
	'nom_reem2'=>$row['nom_reem2'],'reem2'=>$row['reem2'],'incidencia2'=>$row['incidencia2'],
	'nom_reem3'=>$row['nom_reem3'],'reem3'=>$row['reem3'],'incidencia3'=>$row['incidencia3']);
	
	echo json_encode($arreglo);
?>