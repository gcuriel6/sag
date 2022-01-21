<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_departamento = $_REQUEST["id_departamento"];
	
	$query_ant = "SELECT a.id_trabajador, CONCAT (RTRIM(a.nombre),' ', RTRIM(a.apellido_p),' ', RTRIM(a.apellido_m)) AS nombre, c.puesto AS posicion, d.*
				FROM trabajadores a 
				LEFT JOIN contratos_clientes b ON a.id_depto = b.id_depto 
				LEFT JOIN cat_puestos c ON a.id_puesto = c.id_puesto 
				LEFT JOIN horarios d ON d.id_empleado = a.id_trabajador
				WHERE b.id_depto = $id_departamento AND !ISNULL (id_empleado) GROUP BY nombre";
				
				
	$query = "SELECT a.*,CONCAT (TRIM(b.nombre),' ', TRIM(b.apellido_p),' ', TRIM(b.apellido_m)) AS nombre,c.puesto as posicion,b.id_depto as id_depto_trab,
			trim(concat(dia1,dia2,dia3,dia4,dia5,dia6,dia7,dia8,dia9,dia10,dia11,dia12,dia13,dia14,dia15,dia16,dia17,dia18,dia19,dia20,dia21,dia22,dia23,dia24,dia25,dia26,dia27,dia28,dia29,dia30,dia31)) AS cadena
			FROM horarios a 
			LEFT JOIN trabajadores b ON a.id_empleado = b.id_trabajador
			LEFT JOIN cat_puestos c ON a.id_puesto = c.id_puesto
			WHERE a.id_depto = $id_departamento ORDER BY id_empleado";

	// echo $query;
	// exit();
				
	$resultado=mysqli_query($link,$query);
	$num = mysqli_num_rows($resultado);
	
	$arreglo = array();
	$arreglo[0]=$num;
	
	while($row = mysqli_fetch_array($resultado))
	{
		$arreglo[] = array('id_trabajador'=>$row['id_empleado'],
						'difvacante'=>$row['difvacante'],
						'nombre'=>($row['nombre']==NULL)?'VACANTE':$row['nombre'],
						'descr'=>$row['descr'],
						'posicion'=>$row['posicion'],
						'fecha_dia1'=>$row['fechadia1'],
						'id_depto'=>$row['id_depto'],
						'id_depto_trab'=>$row['id_depto_trab'],
						'cadena'=>$row['cadena'],
						'id_registro'=>$row['id_registro']);
						
	}	
	
	echo json_encode($arreglo);
?>