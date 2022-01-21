<?php
	session_start();
	include '../../php/conectar.php';
	$link = Conectarse();
	$user = $_SESSION['usuario_secorp'];
	$id_empleado = $_REQUEST['id_empleado'];
	$monto = $_REQUEST['monto'];
	$quincena = $_REQUEST['quincena'];
	$ano = $_REQUEST['ano'];
	$id_depto = $_REQUEST['id_depto'];
	
	
	$query = "SELECT id_empleado 
				FROM anticipos 
				WHERE id_empleado='$id_empleado' AND quincena='$quincena' AND ano='$ano' and prestamo=0";
	
	$Consulta=mysqli_query($link,$query);
	
	if(mysqli_num_rows($Consulta))
	{
		$query1 = "UPDATE anticipos SET monto=$monto, monto_sol=$monto, rh='0' WHERE id_empleado='$id_empleado' 
					AND quincena='$quincena' AND ano='$ano' AND prestamo='0'";
		$Consulta=mysqli_query($link,$query1);
	}
	else 
	{
		$query1 = "INSERT INTO anticipos (id_empleado,id_depto,quincena,ano,monto,monto_sol) 
						VALUES ('$id_empleado','$id_depto','$quincena','$ano','$monto','$monto')";
		$Consulta=mysqli_query($link,$query1);
	}
	mysqli_close($link);
?>