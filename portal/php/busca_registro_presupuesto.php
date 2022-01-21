<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$registro = $_REQUEST["registro"];
	
	
	
	$query = "SELECT a.*,b.puesto FROM presupuesto a LEFT JOIN cat_puestos b ON a.id_puesto = b.id_puesto  WHERE registro = $registro";
	$result=mysqli_query($link, $query);
	
	
	
	
	$row = mysqli_fetch_array($result);
	
	$arreglo = array('registro'=>$row['registro'],'id_sucursal'=>$row['id_sucursal'],'id_depto'=>$row['id_depto'],'puesto'=>$row['puesto'],'id_puesto'=>$row['id_puesto'],'oficiales'=>$row['oficiales'],'sueldo_quincena'=>$row['sueldo_quincena'],'dia31'=>$row['dia31'],'dia_festivo'=>$row['dia_festivo'],'bono_variable'=>$row['bono_variable'],'bono_quincena'=>$row['bono_quincena'],'tiempos_extras'=>$row['tiempos_extras'],'observaciones'=>$row['observaciones'],'validado'=>$row['validado']);
	
	echo json_encode($arreglo);
?>