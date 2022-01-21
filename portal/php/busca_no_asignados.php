<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_departamento = $_REQUEST["id_departamento"];
	
	$query = "SELECT a.id_trabajador, CONCAT (RTRIM(a.nombre),' ', RTRIM(a.apellido_p),' ', RTRIM(a.apellido_m)) AS nombre FROM trabajadores a
				LEFT JOIN horarios c ON c.id_empleado = a.id_trabajador WHERE a.fecha_baja = '0000-00-00' AND a.id_depto = $id_departamento AND ISNULL (id_empleado)";
				
	$resultado=mysqli_query($link,$query);
	$num = mysqli_num_rows($resultado);
	
	$arreglo = array();
	$arreglo[0]=$num;
	
	while($row = mysqli_fetch_array($resultado))
	{
		$arreglo[] = array('id_trabajador'=>$row['id_trabajador'],'nombre'=>$row['nombre']);
	}	
	
	echo json_encode($arreglo);
?>