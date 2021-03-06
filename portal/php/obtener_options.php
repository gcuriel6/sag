<?php
	
	session_start();
	$user = $_SESSION['usuario'];
	$unidad = $_SESSION['id_unidad_actual'];

	include '../../php/conectar.php';

	$link = Conectarse();


	function checaBit($permiso_forma,$permiso_usuario)
	{	
		if(($permiso_forma & $permiso_usuario)==0)
			return 0;
		else 
			return 1;
	}
	
	function checaPermisoForma($forma,$usuario,$unidad,$link){
		
		$query = 	"SELECT permiso FROM permisos WHERE pantalla = '$forma' AND usuario = '$usuario' AND id_unidad_negocio='$unidad' ";
		//echo $query;
		$Consulta=mysqli_query($link,$query);
		if($Consulta)
		{
			$row = mysqli_fetch_array($Consulta);
			
			return $row['permiso'];
		}
		else 
		{
			
			return 0;	
		}
	}
		
	$tipo = $_REQUEST["tipo"];
	
	if($tipo == "reportes")
	{
		$permisos = checaPermisoForma('REPORTES_WEB', $user,$unidad, $link);
		
		$query = "SELECT * FROM reportes ORDER BY id_reporte";
		$Consulta=mysqli_query($link,$query);
		echo "<option class='o_reporte' value='' selected disabled ></option>";
		while($row = mysqli_fetch_array($Consulta)){
			$per = $row['permiso'];
			if(checaBit($permisos,(int)$per))
				echo "<option class='o_reporte' value='".$row["id_reporte"]."-".$row["tipo"]."'>".$row['nombre_reporte']."</option>";
		
		}
	}
	if($tipo == "puestos")
	{
		
		$query = "SELECT * FROM cat_puestos ORDER BY puesto";
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_puestos' value='".$row["id_puesto"]."'>".$row["puesto"]."</option>";
	}
	else if($tipo == "personal")
	{
		
		$query = "SELECT * FROM usuarios ORDER BY nombre_comp";
		$Consulta=mysqli_query($link,$query);
		echo "<option class='s_personal' value=''>Seleccione Personal</option>";
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='s_sucursal' alt='".$row["usuario"]."' value='".$row["id_usuario"]."'>".$row["nombre_comp"]."</option>";
	}
	else if($tipo == "sucursales")
	{
		
		$query = "SELECT * FROM sucursales";
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_sucursales' value='".$row["id_sucursal"]."'>".$row["descr"]."</option>";
	}
	else if($tipo == "deptos")
	{
		
		$query = "SELECT * FROM deptos";
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_deptos' value='".$row["id_depto"]."'>".$row["des_dep"]."</option>";
	}
	else if($tipo == "deptos_supervisor")
	{
		$id_supervisor = $_REQUEST['id_supervisor'];
		$query = "SELECT a.id_depto,a.des_dep,b.id_registro 
			FROM deptos a 
			LEFT JOIN contratos_clientes c ON a.id_depto = c.id_depto
			LEFT JOIN horarios b ON a.id_depto = b.id_depto 
			
			WHERE inactivo != 1  AND c.id_supervisor = $id_supervisor
			GROUP BY a.id_depto
			/*HAVING !ISNULL(b.id_registro)*/
			ORDER BY des_dep";
		echo "<option class='o_deptos' value='' selected disabled >Seleccionar Depto</option>";
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_deptos' value='".$row["id_depto"]."'>".$row["des_dep"]."</option>";
	}
	else if($tipo == "super_sucursal")
	{
		$id_sucursal = $_REQUEST['id_sucursal'];
		$query = "SELECT a.id_supervisor,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p)) as nombre FROM contratos_clientes a 
					LEFT JOIN trabajadores b ON a.id_supervisor = b.id_trabajador 
					WHERE b.fecha_baja = '0000-00-00' AND b.id_sucursal = $id_sucursal
					GROUP BY id_supervisor
					ORDER BY nombre";
		echo "<option class='o_super' value='' selected disabled >Seleccionar Supervisor</option>";
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_super' value='".$row["id_supervisor"]."'>".$row["nombre"]."</option>";
	}
		else if($tipo == "estados")
	{
		
		$query = "SELECT id as id_estado,estado FROM estados";
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_deptos' value='".$row["id_estado"]."'>".utf8_encode($row["estado"])."</option>";
	}
		else if($tipo == "municipios")
	{
		
		$estado = $_REQUEST["estado"];
		$query = "SELECT id as id_municipio,id_estado,municipio FROM municipios WHERE id_estado =".$estado;
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_deptos' value='".$row["id_municipio"]."'>".utf8_encode($row["municipio"])."</option>";
	}
	else if($tipo == "estado_c")
	{
		
		$query = "SELECT * FROM cat_estadocivil";
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_deptos' value='".$row["id_estadocivil"]."'>".$row["estadocivil"]."</option>";
	}
	else if($tipo == "documentos")
	{
		
		$query = "SELECT * FROM cat_documentos ORDER BY documentos";
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_doctos' value='".$row["documentos"]."' >".$row["nombre"]."</option>";
	}
	
	else if($tipo == "bimestre")
	{
		$ano = $_REQUEST["ano_b"];
		$query = "SELECT distinct bimestre FROM periodos WHERE ano = '$ano' ";
		
		//echo $query;
		echo "<option class='o_bimestre' value='' selected disabled ></option>";
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_bimestre' value='".$row["bimestre"]."'>".$row["bimestre"]."</option>";
	}
	else if($tipo == "ano_b")
	{
		$query = "SELECT DISTINCT ano FROM periodos ";
	
		echo $query;
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_anos' value='".$row["ano"]."'>".$row["ano"]."</option>";
	}




	else if($tipo == "quincenas")
	{
		$ano = $_REQUEST["ano"];
		$query = "SELECT quincena FROM periodos WHERE ano = '$ano' ";
		
		//echo $query;
		echo "<option class='o_quincenas' value='' selected disabled ></option>";
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_quincenas' value='".$row["quincena"]."'>".$row["quincena"]."</option>";
	}
	else if($tipo == "ano")
	{
		$query = "SELECT DISTINCT ano FROM periodos ";
	
		//echo $query;
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_anos' value='".$row["ano"]."'>".$row["ano"]."</option>";
	}
	else if($tipo == "motivos_inc")
	{
		
		$query = "SELECT * FROM motivos WHERE ipad_inc = 1 AND muestra = 0";
		$Consulta=mysqli_query($link,$query);
		echo "<option class='o_motivos_inc' alt='' value='' selected disabled ></option>";
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_motivos_inc' alt='".$row["descr"]."' alt2='".$row["remplazo"]."' alt3='".$row["evento_fac"]."' value='".$row["clave"]."' >".$row["clave"]."</option>";
	}
	else if($tipo == "motivos_rem")
	{
		
		$query = "SELECT * FROM motivos WHERE ipad_rem = 1 AND muestra = 0 ";
		$Consulta=mysqli_query($link,$query);
		echo "<option class='o_motivos_rem' alt='' value='' selected ></option>";
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_motivos_rem' alt='".$row["descr"]."' alt2='".$row["remplazo"]."' alt3='".$row["evento_fac"]."' value='".$row["clave"]."' >".$row["clave"]."</option>";
	}
	else if($tipo == "tipo_eve")
	{
		echo "<option class='o_tipo_eve' value='0' selected disabled ></option>";
		echo "<option class='o_tipo_eve' value='1' >Evento Especial</option>";
		echo "<option class='o_tipo_eve' value='2' >Curso</option>";

	}
		else if($tipo == "tipo_fac")
	{
		
		echo "<option class='o_tipo_fac' value='0' selected disabled ></option>";
		echo "<option class='o_tipo_fac' value='1' >Facturable</option>";
		echo "<option class='o_tipo_fac' value='2' >No Facturable</option>";
	}
	else if($tipo == "super_anticipos")
	{
		$id_supervisor = $_REQUEST['id_supervisor'];
		$per = '2';
		if($id_supervisor == 0){
			$permisos = checaPermisoForma('PORTAL', $user,$unidad, $link);
			if(checaBit($permisos,(int)$per)){
				$query = "SELECT a.id_supervisor,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p)) as nombre FROM contratos_clientes a 
						LEFT JOIN trabajadores b ON a.id_supervisor = b.id_trabajador 
						WHERE b.fecha_baja = '0000-00-00' AND b.id_sucursal in (SELECT id_sucursal FROM accesos WHERE usuario='$user')
						GROUP BY id_supervisor
						ORDER BY nombre";
				echo "<option class='o_super' value='' selected disabled >Seleccionar Supervisor</option>";	
			}
		}
		else {
			$query = "SELECT a.id_supervisor,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p)) as nombre FROM contratos_clientes a 
						LEFT JOIN trabajadores b ON a.id_supervisor = b.id_trabajador 
						WHERE b.fecha_baja = '0000-00-00' AND id_trabajador=$id_supervisor
						GROUP BY id_supervisor
						ORDER BY nombre";
			echo "<option class='o_super' value='' selected disabled >Seleccionar Supervisor</option>";
		}	
		$Consulta=mysqli_query($link,$query);
		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_super' value='".$row["id_supervisor"]."'>".$row["nombre"]."</option>";
	}
	else if($tipo == "super_incidencias")
	{

		$id_supervisor = $_REQUEST['id_supervisor'];
		$per = '1';
		if($id_supervisor == 0){
			$permisos = checaPermisoForma('PORTAL', $user,$unidad, $link);

			if(checaBit($permisos,(int)$per)){
				$query = "SELECT a.id_supervisor,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p)) as nombre FROM contratos_clientes a 
						LEFT JOIN trabajadores b ON a.id_supervisor = b.id_trabajador 
						WHERE b.fecha_baja = '0000-00-00' AND b.id_sucursal in (SELECT id_sucursal FROM accesos WHERE usuario='$user')
						GROUP BY id_supervisor
						ORDER BY nombre";
				echo "<option class='o_super' value='' selected disabled >Seleccionar Supervisor</option>";	
			}
		}
		else {
			$query = "SELECT a.id_supervisor,CONCAT(TRIM(b.nombre),' ',TRIM(b.apellido_p)) as nombre FROM contratos_clientes a 
						LEFT JOIN trabajadores b ON a.id_supervisor = b.id_trabajador 
						WHERE b.fecha_baja = '0000-00-00' AND id_trabajador=$id_supervisor
						GROUP BY id_supervisor
						ORDER BY nombre";
			echo "<option class='o_super' value='' selected disabled >Seleccionar Supervisor</option>";
		}	

		$Consulta=mysqli_query($link,$query);

		while($row = mysqli_fetch_array($Consulta))
			echo "<option class='o_super' value='".$row["id_supervisor"]."'>".$row["nombre"]."</option>";
	}
	mysqli_close($link);
?>

