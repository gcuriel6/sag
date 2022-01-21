<?php
    session_start();
	include '../../php/conectar.php';
	$link = Conectarse();
	$id_supervisor = $_REQUEST['id_supervisor'];
	$id_depto = $_REQUEST['id_depto'];
	$tipo = $_REQUEST["tipo"];
	
	if($tipo == "checar")
	{
		$query0 = "SELECT id_sucursal FROM deptos WHERE id_depto=$id_depto";

		//$query0 = "SELECT id_compania FROM trabajadores WHERE id_trabajador=$id_supervisor";
		
		$Consulta=mysqli_query($link,$query0);
		$row = mysqli_fetch_array($Consulta);
		
		$id_sucursal = $row["id_sucursal"];
		
		$query1 = "SELECT a.quincena,a.ano,
					IFNULL((SELECT 1 FROM periodos_s WHERE quincena=a.quincena AND ano=a.ano AND nomina=0 AND id_sucursal=$id_sucursal),0) AS cerrado,
					IFNULL((SELECT 1 FROM bita_anti_super WHERE quincena=a.quincena AND ano=a.ano AND id_supervisor=$id_supervisor),0) AS dep_cer
					FROM periodos a WHERE CURDATE() BETWEEN a.fec_ini AND a.fec_fin";
		
		
		$Consulta1=mysqli_query($link,$query1);
		$row1 = mysqli_fetch_array($Consulta1);
		
		$arr = array();
		$arr[0] = array('quincena'=>$row1['quincena'],'ano'=>$row1['ano'],'cerrado'=>$row1['cerrado'],'dep_cer'=>$row1['dep_cer']);
		echo json_encode($arr);
	}
	else if($tipo == "cerrar")
	{
		$query2 = "INSERT INTO bita_anti_super (quincena,ano,id_supervisor,cerrada) 
					VALUES ((SELECT quincena FROM periodos WHERE CURDATE() BETWEEN fec_ini AND fec_fin),
							(SELECT ano FROM periodos WHERE CURDATE() BETWEEN fec_ini AND fec_fin),$id_supervisor,1)";

		$result = mysqli_query($link,$query2);
			if($result)
				echo 1;
			else
				echo "No se pudo liberar los departamento del supervisor";				
	}	
	mysqli_close($link);
?>