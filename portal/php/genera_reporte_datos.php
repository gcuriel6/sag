<?php 	
	include '../../php/conectar.php';
	
	function normaliza($texto,$longitud)
	{
		$ntexto='';
		$aux = str_split($texto,$longitud);
		$cont=0;
		while($cont < sizeof($aux))
		{
			$ntexto.=$aux[$cont]."<br>";
			$cont++;
		}
		return $ntexto;		
	}
	
	function fechaBd($fecha) {//cambia la fecha a dd/mm/yyyy    
		list($dia, $mes, $anyo) = explode("/", $fecha);
		$fechamod = $anyo . "-" . $mes . "-" . $dia;
		return $fechamod;
	}
	
	
	$link = Conectarse();

	$id_reporte = $_REQUEST['id_reporte'];
	
	$query = "SELECT * FROM reportes WHERE id_reporte = $id_reporte";
	$resultado = mysqli_query($link,$query);
	$row = mysqli_fetch_array($resultado);
	
	$tipo = $row['tipo'];
	
	if($tipo == 1){
	$fecha_ini = $_REQUEST['fecha_inicio'];
	$fecha_fin = $_REQUEST['fecha_fin'];
	
	$fecha_ini=(($fecha_ini!='') ? fechaBd($fecha_ini) : '');
	$fecha_fin=(($fecha_fin!='') ? fechaBd($fecha_fin) : '');
	}
	else if($tipo == 2){
	$ano = $_REQUEST['ano'];
	$quincena = $_REQUEST['quincena'];
	}
	else if($tipo == 3){
	$fecha_ini = $_REQUEST['fecha_inicio'];
	$fecha_fin = $_REQUEST['fecha_fin'];
	
	$fecha_ini=(($fecha_ini!='') ? fechaBd($fecha_ini) : '');
	$fecha_fin=(($fecha_fin!='') ? fechaBd($fecha_fin) : '');
	}
	else if($tipo == 4){
	$fecha_ini = $_REQUEST['fecha_inicio'];
	$fecha_fin = $_REQUEST['fecha_fin'];
	
	$fecha_ini=(($fecha_ini!='') ? fechaBd($fecha_ini) : '');
	$fecha_fin=(($fecha_fin!='') ? fechaBd($fecha_fin) : '');
	}
	else if($tipo == 5){
	$ano = $_REQUEST['ano'];
	$quincena = $_REQUEST['quincena'];
	}

	else if($tipo == 6){
		$ano = $_REQUEST['ano'];
		$bimestre = $_REQUEST['bimestre'];
	}
	//cambio el format
	
    
	
	
	if($tipo==1)
	{
		if($fecha_ini!='' && $fecha_fin=='')
		{
			$condicion=" HAVING fecha >='$fecha_ini' ";
			
		}elseif($fecha_ini=='' && $fecha_fin!='')
		{
			$condicion=" HAVING fecha <='$fecha_fin' ";
			
		}elseif($fecha_ini=='' && $fecha_fin=='')
		{
			$condicion='';
		}
		else
		{
			$condicion=" HAVING fecha BETWEEN '$fecha_ini' AND '$fecha_fin' ";
		}
			
			      $query = $row['query']. $condicion. $row['post_query'];
				
	}
	else if($tipo==2)
	{
		$condicion= " AND quincena = $quincena AND ano = $ano ";
		$query = $row['query']. $condicion. $row['post_query'];
	}
	else if($tipo==3)
		{
			if($fecha_ini!='' && $fecha_fin=='')
			{
				$condicion=" AND fecha >='$fecha_ini' ";
				
			}elseif($fecha_ini=='' && $fecha_fin!='')
			{
				$condicion=" AND fecha <='$fecha_fin' ";
				
			}elseif($fecha_ini=='' && $fecha_fin=='')
			{
				$condicion='';
			}
			else
			{
				$condicion=" AND fecha BETWEEN '$fecha_ini' AND '$fecha_fin' ";
			}
				
				      $query = $row['query']. $condicion. $row['post_query'];
					
		}
	else if($tipo==4)
		{
			if($fecha_ini!='' && $fecha_fin=='')
			{
				$condicion=" AND fecha_baja >='$fecha_ini' ";
				
			}elseif($fecha_ini=='' && $fecha_fin!='')
			{
				$condicion=" AND fecha_baja <='$fecha_fin' ";
				
			}elseif($fecha_ini=='' && $fecha_fin=='')
			{
				$condicion='';
			}
			else
			{
				$condicion=" AND fecha_baja BETWEEN '$fecha_ini' AND '$fecha_fin' ";
			}
				
				      $query = $row['query']. $condicion. $row['post_query'];
					
		}
	else if($tipo==5)
	{
		$condicion= " AND a.quincena = $quincena AND a.ano = $ano ";
		$query = $row['query']. $condicion. $row['post_query'];
	}
	else if($tipo==6)
	{
		if($bimestre=='')
		{
			$condicion='';
			$query = $row['query']. $condicion. $row['post_query'];
		}
		else {
			$condicion= " AND bi.bimestre = $bimestre AND bi.ano = $ano ";
			$query = $row['query']. $condicion. $row['post_query'];
		}
	}
	else 
	{
		 $query = $row['query'];
	}
	
	// echo $query;
	// exit();
	

	$enlace1 = '#';
	$llave_enlace1 = '';
	
	$resultado = mysqli_query($link,$query);
	
	if($resultado)
	{
		$registro = mysqli_fetch_array($resultado);
		$columnas = sizeof($registro)/2;
		$campos = array_keys($registro);
			
		echo "<table class='query_table'><tr class='tr_primero'>";
		$cont=0;
		foreach($campos as $campo)
		{
			if(is_string($campo))
			{
			$campos2[$cont] = $campo;
			printf("<td>%s</td>",$campo);
			$cont++;
			}
		}
		echo "</tr>";
		$resultado = mysqli_query($link,$query);
		while($registro = mysqli_fetch_array($resultado))
		{
			
			echo "<tr class='renglon'>";
			foreach($campos2 as $field)
			{
				$texto = $registro[$field];
				
				$text = normaliza($texto,60);
				switch($field)
				{
					case $llave_enlace1:
						printf("<td><a href='$enlace1?$field=%s'>%s</a></td>",$registro[$field],$registro[$field]);
					break;
					case $llave_enlace2:
						printf("<td><a href='$enlace2?id=%s'>%s</a></td>",$registro["id"],$registro[$field]);
					break;
					default:
						printf("<td>%s</td>",$text);
					break;
						
				}	
						
			}
			echo "</tr>";
		}		
		echo "</table>";
		
	}
	else 
	{
		echo "Error, en el Query";
	}	
?>