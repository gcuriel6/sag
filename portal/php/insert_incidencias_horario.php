<?php	
	header('Content-Type: charset=utf-8');
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_registro = $_REQUEST['id_registro'];
	
	function sumaFecha($fech,$dias){
		list($ano,$mes,$dia) = explode('-',$fech);
   		return date('Y-m-d',mktime(0,0,0,$mes,$dia+$dias,$ano));
	}
	
	$query = "SELECT *,trim(concat(dia1,dia2,dia3,dia4,dia5,dia6,dia7,dia8,dia9,dia10,dia11,dia12,dia13,dia14,dia15,dia16,dia17,dia18,dia19,dia20,dia21,dia22,dia23,dia24,dia25,dia26,dia27,dia28,dia29,dia30,dia31)) AS cadena
 ,datediff(CURDATE(),fechadia1) as diferencia,CURDATE() as hoy
	 FROM horarios WHERE id_registro = ".$id_registro;
	
	$resultado = mysqli_query($link,$query);
	$row = mysqli_fetch_array($resultado);
	

	$id_empleado = $row['id_empleado'];
	$difvacante = $row['difvacante'];
	$id_depto = $row['id_depto'];
	$id_sucursal = $row['id_compania'];
	$id_turno = $row['id_turno'];
	$cadenadias = $row['cadena'];
	$fechadia1 =$row['fechadia1'];
	$tamano = strlen($cadenadias);
	$id_puesto = $row['id_puesto'];
	
	$diferencia = $row['diferencia'];
	
	$fecini = $row['hoy'];
	$fecfin = sumaFecha($fecini,60);
	
	$pivote = ($diferencia%$tamano);
	
	
	$query2 = "SELECT a.id_compania,b.id_supervisor FROM deptos a LEFT JOIN contratos_clientes b ON a.id_depto = b.id_depto WHERE a.id_depto =$id_depto";

	$result2 = mysqli_query($link,$query2);
	$row2 = mysqli_fetch_array($result2);
	
	$id_compania = $row2['id_compania'];
	$id_supervisor = $row2['id_supervisor'];
	
	
	$queryfinal="INSERT INTO incidencias2 (id_depto, id_supervisor, quincena, ano, id_compania,id_puesto,fecha,no_turno,horas,id_empleado, incidencia,difvacante) values ";
	
	
	//$queryfinal.="('".$id_depto."','".$id_supervisor."','','','".$id_compania."','".$id_puesto."','','','','".$id_empleado."','','".$difvacante."')";
	
	$fecaux = strtotime($fecini);
	
	$fecfin = strtotime($fecfin);
	
	$auxcadena = $pivote;
	
	for($i=date("Y-m-d",$fecaux); $i<=date("Y-m-d",$fecfin); $i= sumaFecha($i,1))
	{
		
    	$fecha = $i;
		
		$query="SELECT ano,quincena FROM periodos WHERE '$fecha' between fec_ini and fec_fin";
		$result = mysqli_query($link,$query);
		$row = mysqli_fetch_array($result);
		
		$quincena = $row['quincena'];
		$ano = $row['ano'];
		$turno = $cadenadias[$auxcadena];
		switch($turno)
		{
			case X: 
				$incidencia = 'DES';
				break;
			case 0: 
				$incidencia = 'N/A';
				break;
			default: 
				$incidencia = 'NOR';
				break;
		}
		
		$queryfinal.= "('$id_depto','$id_supervisor','$quincena','$ano','$id_compania','$id_puesto','$fecha','$turno',12,'$id_empleado','$incidencia','$difvacante')";
		


		if($i<date("Y-m-d",$fecfin))
		$queryfinal.=',';
	
		
		if($auxcadena < ($tamano-1))
			$auxcadena++;
		else
			$auxcadena= 0;
	}
	
	
	//echo $queryfinal;
	
	 
	if($result = mysqli_query($link,$queryfinal)){
		echo 1;
	}
	else{
		echo mysqli_error($link);
	}
	
?>