<?php
	//--- Inicia Encabezado para conexion Mysql (sustituirlo por include proximamente)
	$link = mysqli_connect("192.168.0.166", "root", "denk3n!.", "ginthercorp");
	mysqli_set_charset($link,'utf8');
	//---Finaliza
	
	function sumaFecha($fech,$dias){
		list($ano,$mes,$dia) = explode('-',$fech);
   		return date('Y-m-d',mktime(0,0,0,$mes,$dia+$dias,$ano));
	}
	
	$query = "SELECT * FROM vw_vencimiento_incidencias_n WHERE pivote > 0";
	$resultado = mysqli_query($link,$query);
	while($renglon = mysqli_fetch_array($resultado))
	{
	
		$par_emp=$renglon['id_empleado']; //<--- Numero de nomina del empleado
		echo $par_emp.' -> ';
		$vacante= $renglon['difvacante'];//<--- En caso de ser una vacante este valor nos dice el numero de vacante que es
		
	 	$cadenadias=$renglon['cadena'];//<--- Cadena que contiene el patron del horario a ingresar
		
		$numdias = strlen($cadenadias);//<--- Obtenemos la longitud de la cadena
		
		
		$pivote=$renglon['pivote'];//<--- Valor que contiene en que posicion de cadenadias empieza a realizar los inserts.
		
		$pivote--;	//<---------------- Esto es porque cadenadias empieza en 0 y no en 1
		
		$superv=$renglon['id_supervisor'];//<--- Id del supervisor a cargo del empleado
		
		//echo $renglon['ultima'].' -> ';
		
		$undia = date_create($renglon['ultima']);
		date_add($undia, date_interval_create_from_date_string('1 days'));
		$fecini = date_format($undia, 'Y-m-d');
		//echo $fecini.' -> ';
		
		//$fecini=$renglon['ultima'];//<--- Fecha de inicio para las incidencias.
		
		$tresmeses = date_create($renglon['ultima']);
		date_add($tresmeses, date_interval_create_from_date_string('92 days'));
		$fecfin = date_format($tresmeses, 'Y-m-d');
		
		//echo $fecfin.'<br>';
		
		//$fecfin=$renglon['ultima'];//<--- Fecha limite de ingreso de las incidencias.
		
		$depto=$renglon['id_depto'];
		
		
		
		if($par_emp==0)
			$query = "DELETE FROM incidencias2 WHERE id_empleado=$par_emp AND difvacante=$vacante AND id_depto = $depto AND fecha >= '$fecini' AND incidencia_aux != 'VAC' AND incidencia_aux != 'INC'  ";
		else
			$query = "DELETE FROM incidencias2 WHERE id_empleado=$par_emp AND fecha >= '$fecini' AND incidencia_aux != 'VAC' AND incidencia_aux != 'INC'  ";
		//echo $query;
		$result = mysqli_query($link,$query);
		
		$query = "SELECT fecha FROM incidencias2 WHERE id_empleado=$par_emp AND id_depto = $depto AND difvacante=$vacante AND(fecha BETWEEN '$fecini' AND '$fecfin')";
		//echo $query;
		$result = mysqli_query($link,$query);
		
		$i=1;
		$incnobor[0]='';
		while($row = mysqli_fetch_array($result))
		{
			$incnobor[$i]=$row["fecha"];
			$i++;
		}
		
		if($par_emp!=0){
			$query = "SELECT id_sucursal,id_puesto FROM trabajadores WHERE id_trabajador=$par_emp and fecha_baja='0000-00-00'";
			//echo $query;
			$result = mysqli_query($link,$query);
			$row = mysqli_fetch_array($result);
			
			$sucursal = $row['id_sucursal'];
			
			$puesto = $row['id_puesto'];
		}
		else {
			$query = "SELECT id_compania FROM deptos WHERE id_depto = $depto";
			//echo $query;
			$result = mysqli_query($link,$query);
			$row = mysqli_fetch_array($result);
			
			$sucursal = $row['id_compania'];
			
			$puesto = 1;
		}
		
		$queryfinal="INSERT INTO incidencias2 (id_depto, id_supervisor, quincena, ano, id_compania,id_puesto, fecha, no_turno,horas,id_empleado, incidencia,difvacante) values ";
		
		
		$fecaux = strtotime($fecini);
		//echo $fecaux;
		$fecfin = strtotime($fecfin);
		//echo $fecfin;
		$auxcadena = $pivote;
		
		for($i=date("Y-m-d",$fecaux); $i<=date("Y-m-d",$fecfin); $i= sumaFecha($i,1))
		{
			
	    	$fecha = $i;
			if(!array_search($fecha, $incnobor))
			{	
				$query="SELECT ano,quincena FROM periodos WHERE '$fecha' between fec_ini and fec_fin";
				$result = mysqli_query($link,$query);
				$row = mysqli_fetch_array($result);
				
				$quincena = $row['quincena'];
				$ano = $row['ano'];
				$turno = $cadenadias[$auxcadena];
				switch($turno)
				{
					case 'X': 
						$incidencia = 'DES';
						break;
					default: 
						$incidencia = 'NOR';
						break;
				}
				
				$queryfinal.= "('$depto','$superv','$quincena','$ano','$sucursal','$puesto','$fecha','$turno',12,'$par_emp','$incidencia','$vacante')";
				
				if($i<date("Y-m-d",$fecfin))
				$queryfinal.=',';
				
			}
				
				if($auxcadena < ($numdias-1))
					$auxcadena++;
				else
					$auxcadena= 0;
		}
		
		//echo $queryfinal.'<br>';
		
		
		if($result = mysqli_query($link,$queryfinal))
			echo " 1<br>";
		else
		{
			echo "0 ".mysqli_error($link).'<br>';
			
		}
		 
		
	}
	 
?>
