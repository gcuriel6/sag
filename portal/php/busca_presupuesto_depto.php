<?php

	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_depto = $_REQUEST["id_depto"];
	
	$arreglo = array();
	
	$query = "SELECT a.*,b.puesto FROM presupuesto a LEFT JOIN cat_puestos b ON a.id_puesto = b.id_puesto WHERE a.id_depto = $id_depto";
	$result=mysqli_query($link, $query);
	$num = mysqli_num_rows($result);
	
	$arreglo[0]= $num;
	
	while($row = mysqli_fetch_array($result))
	{
		$arreglo[] = array('registro'=>$row['registro'],'id_sucursal'=>$row['id_sucursal'],'id_depto'=>$row['id_depto'],'puesto'=>$row['puesto'],'id_puesto'=>$row['id_puesto'],'oficiales'=>$row['oficiales'],'sueldo_quincena'=>$row['sueldo_quincena'],'bono_quincena'=>$row['bono_quincena'],'dia31'=>$row['dia31'],'dia_festivo'=>$row['dia_festivo'],'bono_variable'=>$row['bono_variable'],'tiempos_extras'=>$row['tiempos_extras'],'observaciones'=>$row['observaciones'],'validado'=>$row['validado']);
	}
	echo json_encode($arreglo);
?>