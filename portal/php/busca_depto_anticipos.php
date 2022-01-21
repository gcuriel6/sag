<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_depto = $_REQUEST["id_depto"];
	
	$arreglo = array();
	
	$query = 	"SELECT IFNULL(CONCAT(TRIM(a.apellido_p),' ',TRIM(a.apellido_m),' ',TRIM(a.nombre)),'0 VACANTE') AS nombre,
					IFNULL(a.id_trabajador,0) AS id_trabajador,
					a.id_depto,
					(SELECT quincena FROM periodos WHERE CURDATE() BETWEEN fec_ini AND fec_fin) AS quincena,
					(SELECT ano FROM periodos WHERE CURDATE() BETWEEN fec_ini AND fec_fin) AS ano,
					IFNULL(b.monto,0) AS monto,
					IF(IFNULL(b.autorizado,0)=0,'N','S') AS autorizado 
				FROM trabajadores a 
				LEFT JOIN anticipos b ON a.id_trabajador=b.id_empleado AND 
					(SELECT quincena FROM periodos WHERE CURDATE() BETWEEN fec_ini AND fec_fin)=b.quincena AND 
					(SELECT ano FROM periodos WHERE CURDATE() BETWEEN fec_ini AND fec_fin)=b.ano AND prestamo=0
				WHERE a.id_depto=".$id_depto." AND fecha_baja='0000-00-00' AND administrativo<>2
				GROUP BY id_trabajador";

	$result=mysqli_query($link,$query);
	$num = mysqli_num_rows($result);
	
	$arreglo[0]= $num;
	
	while($row = mysqli_fetch_array($result))
	{
		$arreglo[] = array('id_trabajador'=>$row['id_trabajador'],'nombre'=>$row['nombre'],'monto'=>$row['monto'],'autorizado'=>$row['autorizado'],'id_depto'=>$row['id_depto'],'quincena'=>$row['quincena'],'ano'=>$row['ano']);
	}
	echo json_encode($arreglo);
	
	mysqli_close($link);
?>