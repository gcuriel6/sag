<?php

	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_depto = $_REQUEST["id_depto"];
	$opcion = $_REQUEST["opcion"];
	$hoy = $_REQUEST["fecha"];
	
	$hoy = $hoy.date(" h:i:s");
	
	$query = "UPDATE deptos SET validado_presupuesto = $opcion WHERE id_depto = $id_depto";
	
	
	$result=mysqli_query($link, $query);
	
	$aux=0;
	
	if($result){
		
		if($opcion == 1){
			$query2 = "SELECT * FROM presupuesto WHERE id_depto = $id_depto";
			$result2 = mysqli_query($link, $query2);
			while($row=mysqli_fetch_array($result2)){
				
				$query3 = "INSERT INTO presupuesto_historial(id_sucursal,id_depto,id_puesto,mes,ano,oficiales,sueldo_quincena,bono_quincena,tiempos_extras,observaciones,fecha) VALUES ('".$row['id_sucursal']."','".$row['id_depto']."','".$row['id_puesto']."','".$row['mes']."','".$row['ano']."','".$row['oficiales']."','".$row['sueldo_quincena']."','".$row['bono_quincena']."','".$row['tiempos_extras']."','".$row['observaciones']."','".$hoy."')";
				
				$result3 = mysqli_query($link, $query3);
				
			}
			if($result3){
					echo 1;
			}
			else
				echo mysqli_error();
			
		}else{
			echo 1;
		}

	}
	else {
		echo mysqli_error();
	}

	 
?>