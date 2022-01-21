<?php
	error_reporting(0);
	include '../../php/conectar.php';
	$link= Conectarse();
	
	function sumaFecha($fech,$dias){
		list($ano,$mes,$dia) = explode('-',$fech);
   		return date('Y-m-d',mktime(0,0,0,$mes,$dia+$dias,$ano));
	}
	
	$quincena = $_REQUEST['quincena'];
	$ano = $_REQUEST['ano'];;
	$super = $_REQUEST['super'];
	
	$query = "SELECT a.fec_ini,a.fec_fin,DATEDIFF(a.fec_fin,a.fec_ini) as dif_dias
				FROM periodos a 
				WHERE a.quincena = $quincena AND a.ano = $ano;";
	
	$result = mysqli_query($link,$query);
	$periodos = mysqli_fetch_array($result);
	
	$fini = $periodos['fec_ini'];   //fecha de inicio del Periodo
	$ffin = $periodos['fec_fin'];   // fecha de fin del Periodo
	
	$ini = strtotime($periodos['fec_ini']); //F UNIX  de inicio
	$fin = strtotime($periodos['fec_fin']); //F UNIX de fin
	
	$difdias = $periodos['dif_dias']; // diferencia de dias entre las dos fechas
	
	$fecha_impresion = date("Y-m-d").' '.date("H:i:s") ;
?>
<html>
	<head>

	</head>

	<link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
	<link rel="stylesheet" href="css/datepicker.css" />
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/alert.js"></script>

	<style>
		td {
			border: solid 1px #000;
			padding: 2px 2px;
			font-size: 9px;
		}
		table {
			border-collapse: collapse;
		}

		tr:nth-child(even){ background-color:#fefefe; color:#000;}
		tr:hover{ background:#000055; color:#fefefe;}

		.tr_primero {
			background-color: rgba(0,0,0,0.5);;
			color:#fefefe;
			text-align: left;
		}
		
		.tr_primero:hover {
			background-color: rgba(0,0,0,0.5);;
			color:#fefefe;
			text-align: left;
		}

	</style>
	<body>

		<?php
		echo "Fecha y Hora: ".$fecha_impresion."<br><br>";
		$query = "SELECT a.id_depto AS depto,b.des_dep,CONCAT(TRIM(c.apellido_p),' ',TRIM(c.apellido_m),' ',TRIM(c.nombre)) AS nombre_c FROM contratos_clientes a 
						LEFT JOIN deptos b ON a.id_depto= b.id_depto
						LEFT JOIN trabajadores c ON a.id_supervisor = c.id_trabajador
						  WHERE a.id_supervisor = $super AND b.inactivo != 1 GROUP BY 1 ORDER BY 2";
						  
		$result = mysqli_query($link,$query);
		while ($row = mysqli_fetch_array($result)) {
			//echo date("h:i:s")."<br>";
			$depto = $row['depto'];
			printf('<table><tr class="tr_primero"><td>Departamento:</td><td>%s</td><td>Supervisor:</td><td>%s</td></tr>', $row['des_dep'], $row['nombre_c']);
			echo '</table><table>';

			echo '<tr class="tr_primero"><td>cve</td><td>FIng</td><td>trabajador</td>';
			
			for ($i = date("Y-m-d",$ini); $i <= date("Y-m-d", $fin); $i= sumaFecha($i,1))
			{
				
				$aux =  strtotime($i);
				printf('<td>%s</td>', date('m/d',$aux));
			}
			 
			 
			echo '<td>SUE</td><td>DED</td><td>INF</td><td>TIE</td><td>OTR</td><td>SUB</td><td>PRI</td><td>VTA</td><td>BON</td><td>NVI</td><td>T_DES</td><td>B_EMP</td><td>B_HEC</td><td>S_VID</td><td>TOTAL</td></tr>';

			$query_p_1 = "SELECT 	a.id_trabajador,
									CONCAT(TRIM(a.apellido_p),' ',TRIM(a.apellido_m),' ',TRIM(a.nombre)) AS nombre_c,
									a.fecha_ingreso, ";
			$j = 1;
			$query_p_2 = "";
			for ($i = date("Y-m-d",$ini); $i <= date("Y-m-d", $fin); $i= sumaFecha($i,1))
			{
				$query_p_2 .= "inc_dia(a.id_trabajador,'$i') AS '$j', ";
				$j++;
			}

			$query_p_3 = "b.sueldo,
							b.deducciones,
							b.infonavit,
							b.tiempo_e,
							b.o_ingresos,
							b.subtotal,
							b.prima_vac,
							b.vac_trab,
							b.bonos,
							b.des_nvi,
							b.descuentos,
							b.total,
							b.bono_emp,
							b.bono_hec,
							b.seg_vida 
						FROM trabajadores a 
						LEFT JOIN nomina b ON a.id_trabajador=b.id_empleado AND $quincena=b.quincena AND $ano=b.ano
						WHERE a.id_depto=$depto AND fecha_baja = '0000-00-00';";
			$query_n = $query_p_1 . $query_p_2 . $query_p_3;

			/*echo "Nuevo: ".$query_n."<br><br>";*/

			$result10 = mysqli_query($link,$query_n);

			while ($row10 = mysqli_fetch_array($result10)) 
			{
				printf('<tr><td>%s</td><td>%s</td><td>%s</td>', $row10['id_trabajador'], $row10['fecha_ingreso'], $row10['nombre_c']);

				$l=1;

				for ($k = date("Y-m-d",$ini); $k <= date("Y-m-d", $fin); $k= sumaFecha($k,1))
				{
					printf("<td>%s</td>",$row10[$l]);
					$l++;
				}

				printf("<td>%s</td>", $row10['sueldo']);
				printf("<td>%s</td>", $row10['deducciones']);
				printf("<td>%s</td>", $row10['infonavit']);
				printf("<td>%s</td>", $row10['tiempo_e']);
				printf("<td>%s</td>", $row10['o_ingresos']);
				printf("<td>%s</td>", $row10['subtotal']);
				printf("<td>%s</td>", $row10['prima_vac']);
				printf("<td>%s</td>", $row10['vac_trab']);
				printf("<td>%s</td>", $row10['bonos']);
				printf("<td>%s</td>", $row10['des_nvi']);
				printf("<td>%s</td>", $row10['descuentos']);
				printf("<td>%s</td>", $row10['bono_emp']);
				printf("<td>%s</td>", $row10['bono_hec']);
				printf("<td>%s</td>", $row10['seg_vida']);
				printf("<td>%s</td>", $row10['total']);
	
				echo "</tr>";

			}


			echo "</table><br>";
			printf('<table><tr class="tr_primero"><td>Remplazos:</td><td>%s</td></tr>', $row['des_dep'], $row['nombre_c']);
			echo '<table><tr class="tr_primero"><td>cve</td><td>fecha</td><td>trabajador</td><td>inc</td><td>Comentario</td></tr>';

			$result1 = mysqli_query($link, 'DROP TEMPORARY TABLE IF EXISTS treem1;');
	$result11 = mysqli_query($link, "CREATE TEMPORARY TABLE treem1 AS (
	  SELECT a.fecha AS fecha,a.reem1 AS id_empleado,c.nombre AS nom_empleado,a.incidencia1 AS inc,CONCAT('REEMPLAZO A:',IFNULL(b.nombre,'Vacante')) AS justificacion,a.quincena AS quincena,a.ano AS ano,a.id_depto AS id_depto,a.id_supervisor AS id_supervisor 
	FROM incidencias2 a 
	LEFT JOIN trabajadores b ON(a.id_empleado = b.id_trabajador) 
	LEFT JOIN trabajadores c ON(a.reem1 = c.id_trabajador) 
	WHERE (a.reem1 <> '') AND a.id_depto = $depto AND quincena = $quincena AND ano = $ano);");
	
	$result2 = mysqli_query($link, 'DROP TEMPORARY TABLE IF EXISTS treem2;');
	$result22 = mysqli_query($link, "CREATE TEMPORARY TABLE treem2 AS (
	  SELECT a.fecha AS fecha,a.reem2 AS id_empleado,c.nombre AS nom_empleado,a.incidencia1 AS inc,CONCAT('REEMPLAZO A:',IFNULL(b.nombre,'Vacante')) AS justificacion,a.quincena AS quincena,a.ano AS ano,a.id_depto AS id_depto,a.id_supervisor AS id_supervisor 
	FROM incidencias2 a 
	LEFT JOIN trabajadores b ON(a.id_empleado = b.id_trabajador) 
	LEFT JOIN trabajadores c ON(a.reem2 = c.id_trabajador) 
	WHERE (a.reem2 <> '') AND a.id_depto = $depto AND quincena = $quincena AND ano = $ano );");

	$result3 = mysqli_query($link, 'DROP TEMPORARY TABLE IF EXISTS treem3;');
	$result33 = mysqli_query($link, "CREATE TEMPORARY TABLE treem3 AS (
	  SELECT a.fecha AS fecha,a.reem3 AS id_empleado,c.nombre AS nom_empleado,a.incidencia1 AS inc,CONCAT('REEMPLAZO A:',IFNULL(b.nombre,'Vacante')) AS justificacion,a.quincena AS quincena,a.ano AS ano,a.id_depto AS id_depto,a.id_supervisor AS id_supervisor 
	FROM incidencias2 a 
	LEFT JOIN trabajadores b ON(a.id_empleado = b.id_trabajador) 
	LEFT JOIN trabajadores c ON(a.reem3 = c.id_trabajador) 
	WHERE (a.reem3 <> '') AND a.id_depto = $depto AND quincena = $quincena AND ano = $ano );
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
		}
		$fecha_impresion = date("H:i:s") ;
		echo "Fecha y Hora: ".$fecha_impresion."<br><br>";
		mysqli_close($link);
		?>
	</body>
</html>