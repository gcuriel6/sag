<?php
	error_reporting(0);
	include '../../php/conectar.php';
	$link= Conectarse();

	$result1 = mysqli_query($link, 'DROP TEMPORARY TABLE IF EXISTS treem1;');
	$result11 = mysqli_query($link, "CREATE TEMPORARY TABLE treem1 AS (
	  SELECT a.fecha AS fecha,a.reem1 AS id_empleado,c.nombre AS nom_empleado,a.incidencia1 AS inc,CONCAT('REEMPLAZO A:',IFNULL(b.nombre,'Vacante')) AS justificacion,a.quincena AS quincena,a.ano AS ano,a.id_depto AS id_depto,a.id_supervisor AS id_supervisor 
	FROM incidencias2 a 
	LEFT JOIN trabajadores b ON(a.id_empleado = b.id_trabajador) 
	LEFT JOIN trabajadores c ON(a.reem1 = c.id_trabajador) 
	WHERE (a.reem1 <> '') AND a.id_depto = 3785 AND quincena = 3 AND ano = 2021);");
	
	$result2 = mysqli_query($link, 'DROP TEMPORARY TABLE IF EXISTS treem2;');
	$result22 = mysqli_query($link, "CREATE TEMPORARY TABLE treem2 AS (
	  SELECT a.fecha AS fecha,a.reem2 AS id_empleado,c.nombre AS nom_empleado,a.incidencia1 AS inc,CONCAT('REEMPLAZO A:',IFNULL(b.nombre,'Vacante')) AS justificacion,a.quincena AS quincena,a.ano AS ano,a.id_depto AS id_depto,a.id_supervisor AS id_supervisor 
	FROM incidencias2 a 
	LEFT JOIN trabajadores b ON(a.id_empleado = b.id_trabajador) 
	LEFT JOIN trabajadores c ON(a.reem2 = c.id_trabajador) 
	WHERE (a.reem2 <> '') AND a.id_depto = 3785 AND quincena = 3 AND ano = 2021 );");

	$result3 = mysqli_query($link, 'DROP TEMPORARY TABLE IF EXISTS treem3;');
	$result33 = mysqli_query($link, "CREATE TEMPORARY TABLE treem3 AS (
	  SELECT a.fecha AS fecha,a.reem3 AS id_empleado,c.nombre AS nom_empleado,a.incidencia1 AS inc,CONCAT('REEMPLAZO A:',IFNULL(b.nombre,'Vacante')) AS justificacion,a.quincena AS quincena,a.ano AS ano,a.id_depto AS id_depto,a.id_supervisor AS id_supervisor 
	FROM incidencias2 a 
	LEFT JOIN trabajadores b ON(a.id_empleado = b.id_trabajador) 
	LEFT JOIN trabajadores c ON(a.reem3 = c.id_trabajador) 
	WHERE (a.reem3 <> '') AND a.id_depto = 3785 AND quincena = 3 AND ano = 2021 );
		");

	$query4 = "SELECT * FROM treem1
	UNION ALL
	SELECT * FROM treem2
	UNION ALL
	SELECT * FROM treem3 ORDER BY fecha";

	//$query4 = "SELECT * FROM vw_remplasos_full WHERE id_depto = $depto AND quincena = $quincena AND ano = $ano ORDER BY fecha";

			$result4 = mysqli_query($link,$query4);
			while($row4 = mysqli_fetch_array($result4)){
				echo '<tr>';
				printf("<td>%s</td>", $row4['id_empleado']);
				printf("<td>%s</td>", $row4['fecha']);
				printf("<td>%s</td>", $row4['nom_empleado']);
				printf("<td>%s</td>", $row4['inc']);
				printf("<td>%s</td>", $row4['justificacion']);
				echo '<tr>';
			}
			echo "</table><br><br><hr>";


		mysqli_close($link);
?>