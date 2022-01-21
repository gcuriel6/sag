<?php
	session_start();
	include '../../php/conectar.php';
	$link= Conectarse();
	
	$tipo = $_REQUEST["tipo"];
	
	if($tipo == "sucursal")
	{
		echo "<option class='o_empresas' selected disabled></option>";
		$query = "SELECT id_sucursal,descr FROM sucursales";
		//echo $query;
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_empresas' value='".$row["id_sucursal"]."'>".$row["descr"]."</option>";
	}
	else if($tipo == "supervisor")
	{
		$compania= $_REQUEST['compania'];
		$query = "SELECT b.id_sucursal,a.id_supervisor,CONCAT(TRIM(b.apellido_p),' ',TRIM(b.apellido_m),' ',TRIM(b.nombre)) AS nombrec FROM contratos_clientes a 
				LEFT JOIN trabajadores b ON a.id_supervisor = b.id_trabajador
				WHERE b.fecha_baja ='0000-00-00' AND b.id_sucursal = $compania
				GROUP BY 2
				ORDER BY 1,3";
		echo "<option class='o_supervisores' selected disabled></option>";
		//echo $query;
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_supervisores' value='".$row["id_supervisor"]."'>".$row["nombrec"]."</option>";
	}
	
	else if($tipo == "deptos")
	{
		$super= $_REQUEST['super'];
		$query = "SELECT a.id_depto,b.des_dep FROM contratos_clientes a LEFT JOIN  deptos b ON a.id_depto = b.id_depto 
			WHERE a.id_supervisor = $super
			GROUP BY 1
			ORDER BY 2 ";
		echo "<option class='o_deptos' selected disabled></option>";
		//echo $query;
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_deptos' value='".$row["id_depto"]."'>".$row["des_dep"]."</option>";
	}
	else if($tipo == "quincenas")
	{
		$ano = $_REQUEST["ano"];
		$query = "SELECT quincena FROM periodos WHERE ano = '$ano' ";
		echo "<option class='o_quincenas' selected disabled></option>";
		//echo $query;
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_quincenas' value='".$row["quincena"]."'>".$row["quincena"]."</option>";
	}
	else if($tipo == "ano")
	{
		$query = "SELECT DISTINCT ano FROM periodos ";
		echo "<option class='o_anos' selected disabled></option>";
		//echo $query;
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_anos' value='".$row["ano"]."'>".$row["ano"]."</option>";
	}
	
?>