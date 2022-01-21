<?php
	include("../../php/conectar.php");
	$link = Conectarse();
	
	$id_depto = $_REQUEST["id_depto"];
	$fecha = $_REQUEST["fecha"];
	
	$arreglo = array();
	
	$query = "SELECT a.registro,a.id_empleado,a.difvacante,
	IFNULL(CONCAT (RTRIM(b.nombre),' ', RTRIM(b.apellido_p),' ', RTRIM(b.apellido_m)),'VACANTE') AS nombre,
	incidencia,incidencia_aux,c.puesto
	FROM incidencias2 a 
	LEFT JOIN trabajadores b ON a.id_empleado = b.id_trabajador
	LEFT JOIN cat_puestos c ON a.id_puesto = c.id_puesto
	WHERE a.id_depto = $id_depto AND fecha = '$fecha'";
	
	$result=mysqli_query($link,$query);
	$num = mysqli_num_rows($result);
	
	$arreglo[0]= $num;
	
	while($row = mysqli_fetch_array($result))
	{
		$arreglo[] = array('registro'=>$row['registro'],'id_empleado'=>$row['id_empleado'],'difvacante'=>$row['difvacante'],'nombre'=>$row['nombre'],'incidencia'=>$row['incidencia'],'incidencia_aux'=>$row['incidencia_aux'],'puesto'=>$row['puesto']);
	}
	echo json_encode($arreglo);
?>