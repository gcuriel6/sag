<?php 	
	function TablaQuery($query,$hilo,$titulo,$enlace = "#",$llave_enlace = " ",$llave_enlace2 = " ")
	{
		$resultado = mysqli_query($hilo,$query);
		$registro = mysqli_fetch_array($resultado);
		$columnas = sizeof($registro)/2;
		$campos = array_keys($registro);
		
		echo "<center><fieldset><legend>$titulo</legend><center>";
				
		echo "<table class='query_table'><thead><tr class='tr_primero'>";
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
		echo "</tr></thead><tbody>";
		$resultado = mysqli_query($hilo,$query);
		while($registro = mysqli_fetch_array($resultado))
		{
			echo "<tr>";
			foreach($campos2 as $field)
			{
				if(($llave_enlace == $field)||($llave_enlace2 == $field))
				{
					if($llave_enlace == $field)
						$id = $registro[$field];
					printf("<td><a href='$enlace?$llave_enlace=%s'>%s</a></td>",$id,$registro[$field]);
				}
				else
					printf("<td>%s</td>",$registro[$field]);	
			}
			echo "</tr></tbody>";
		}		
		echo "</table>";
		echo "</center></fieldset><br><center>";
	}
	
	echo "<style>
			.query_table td{
			border:	#444 2px solid;
			color:#222;
			font-family:Droid Serif, arial; 
			font-size:14px;
			font-weight:bold;
			border-radius:5px;
			padding:2px 10px;
			text-align:center;}
			
			.tr_primero	td{
			background-color:#222;
			border-radius:5px;
			padding:5px 10px;
			color:#FFFFFF;
			font-family:Droid Serif, arial; 
			font-size:14px;
			font-weight:bold;
			border:	#4297d7 2px solid;
			}
			legend	{
			font-family:Droid Serif, arial; 
			font-size:18px;
			font-weight:bold;
			color:#222;			
			}
			fieldset	{
			border-radius:10px;
			border:	#888 2px solid;
			background-color:white;
			width:90%;
			}
		</style>";	
?>