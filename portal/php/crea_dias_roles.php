<?php

	include 'time.php';
	include '../../php/conectar.php';

	$link = Conectarse();
	
	function sumaFecha($fech,$dias){
		list($ano,$mes,$dia) = explode('-',$fech);
   		return date('Y-m-d',mktime(0,0,0,$mes,$dia+$dias,$ano));
	}
	
	$query = 	"SELECT quincena,ano,fec_ini,fec_fin 
				FROM periodos 
				WHERE (CURDATE() >= fec_ini AND CURDATE() <= fec_fin) ";

	$Consulta=mysqli_query($link,$query);
	$row = mysqli_fetch_array($Consulta);

	$quincena = $row['quincena'];
	$ano = $row['ano'];
	$fec_ini = strtotime($row['fec_ini']);
	$fec_fin = strtotime($row['fec_fin']);
	
	if($quincena < 24){
		$quincena2 = $quincena +1;
		$ano2 = $ano;
	}
	else {
		$quincena2 = 1;
		$ano2 = $ano+1;
	}
	
	$query2 = "SELECT fec_ini,fec_fin FROM periodos WHERE quincena= $quincena2 AND ano = $ano2";
	$Consulta2=mysqli_query($link,$query2);
	$row2 = mysqli_fetch_array($Consulta2);
	
	$fec_ini2 = strtotime($row2['fec_ini']);
	$fec_fin2 = strtotime($row2['fec_fin']);
	
	$hoy = obtieneDate($link);
	
	$mensaje = '<tr class="encabezado" style="background-color:#f2f2f2;"><td width="15%">Nombre</td><td width="20%">Descripción</td><td width="10%">Posición</td>';
	for($i=date("Y-m-d",$fec_ini);$i<=date("Y-m-d",$fec_fin2);$i = sumaFecha($i,1)){
		$aux =  strtotime($i);
		if($i==$hoy){
			$mensaje = $mensaje . '<td class="td_dia hoy" title="'.date("Y-m-d",$aux).'">'.date('d',$aux).'</td>';
		}
		else {
			$mensaje = $mensaje . '<td class="td_dia" title="'.date("Y-m-d",$aux).'">'.date('d',$aux).'</td>';
		}
		//echo $i.'-'.$hoy.'<br>';
	}



	$mensaje = $mensaje .'</tr>';
	echo $mensaje;
	
?>