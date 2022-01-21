<?php
	session_start();

	$id_trabajador = $_REQUEST["id"];
	$user = $_SESSION["usuario"];
	$nivel_user = $_SESSION["niv"];
	
	include '../../php/conectar.php';
	include("php_tools.php");
	$link = Conectarse();
	
	//Checar existencia de archivo de foto
	$dir = "../docs/$id_trabajador";
	if(!file_exists($dir))
	{
		mkdir($dir, 0777);
		chmod($dir, 0777);
	}
	
	$query = "SELECT * FROM fotos WHERE id_trabajador = $id_trabajador";
	$resultado = mysqli_query($link,$query);
	if($registro = mysqli_fetch_array($resultado))	
		if(!file_exists("../docs/".$id_trabajador."/foto.jpg"))
		{
			$file = fopen("../docs/".$id_trabajador."/foto.jpg","wb+");
			fputs($file,$registro["foto"]);
			fclose($file);
		}
	//

		
	$query = "SELECT a.*,b.puesto,c.des_dep,d.descr,e.estado,f.municipio
				FROM trabajadores a 
				LEFT JOIN cat_puestos b ON a.id_puesto = b.id_puesto
				LEFT JOIN deptos c ON a.id_depto = c.id_depto
				LEFT JOIN sucursales d ON a.id_sucursal = d.id_sucursal
				LEFT JOIN estados e ON a.cve_estado = e.id
				LEFT JOIN municipios f ON a.cve_municipio = f.id
				WHERE id_trabajador = $id_trabajador";
	$resultado = mysqli_query($link,$query);
	$registro = mysqli_fetch_array($resultado);	
	
	//obtener permisos de edicion o consulta
	$sucursal = $registro["id_sucursal"];
	$query2 = "SELECT nivel_web,permisos_web, psico_web FROM accesos WHERE usuario = '$user' AND id_sucursal = $sucursal";
	$resultado2 = mysqli_query($link,$query2);
	

	if($registro2 = mysqli_fetch_array($resultado2))
	{
		$nivel = $registro2["nivel_web"];
		$nivel_user = $registro2["nivel_web"];
		$permisos = $registro2["permisos_web"];
		$psico =   $registro2["psico_web"];//checaPermisoForma('EXPEDIENTE_WEB', $user, $link);
	}
	else
	{
		$nivel = 1;
		$permisos = 3;
		//echo "<script language='javascript'>alert('no tienes acceso a esta informacion');window.open('home_b.php','_self');</script>";
	}
	//----------------------------------------

	


	function checaPermisoForma($forma,$usuario,$link){
		
		$query = "SELECT permiso FROM permisos WHERE pantalla = '$forma' AND usuario = '$usuario'";
		//echo $query;
		$Consulta=mysqli_query($link,$query);
		if(mysqli_num_rows($Consulta)>0)
		{	
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
		else 
		{

			return 0;
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Pragma" content="no-cache">
<title>Documento sin t&iacute;tulo</title>
</head>
<link rel="stylesheet" href="css/general.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/bootstrap/bootstrap.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" media="all" />
<style>
	.etiqueta{width:200px; text-align:right; font-weight:bold;}
	td,fieldset	{border-radius:5px; padding:10px 10px;}
	input,select{border-radius:5px; padding:3px 1px; width:200px;}
	.input_corta{width:60px}
	.vinetas	{position:relative;width:80%;height:85%;top:10px;left:10%;overflow: auto;}
	#documentos	{
			position:absolute;
			background-color:#999999;
			top:0%;
			height:100%;
			left:0%;
			width:100%;
						
		}
	#documentos iframe	{
			position:absolute;
			left:5%;
			top:5%;
			height:90%;
			width:90%;
		}
	#d_subir_doc{
			position:absolute;
			background-color:#999999;
			top:35%;
			height:30%;
			left:20%;
			width:60%;
			border-radius:5px;	
			border:medium #CCCCCC solid;		
		}
	#i_files{
			font-size:12px;
			font-family:Verdana, Arial, Helvetica, sans-serif;
			font-weight:bold;
			border-radius: 5px;
			height:30px;
	}
	h2{
			font-size:16px;
			font-family:Verdana, Arial, Helvetica, sans-serif;
			border-radius: 5px;
			height:30px;
	}
	body{
			background-image: url('imagenes/trabajo1.jpg');
				background-repeat: no-repeat;
				background-size: cover;
			}
		#transparencia{
			position: absolute;
			top:0px;
			left: 0px;
			width: 100%;
			height: 100%;
			background-color: rgba(255,255,255,0.7);
		}
</style>

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>

<script>
$(function() 
	{
		var nivel = <?php echo $nivel_user?>;
		var permisos = <?php echo $permisos?>;
		var suc = <?php echo $sucursal?>;
		var archivo_cambio= 0;

		console.log(nivel);
		
		$.get('obtener_options.php',{ tipo: "puestos" }, function(data){ $("#s_puestos").html(data); $('#s_puestos').val(<?php echo $registro['id_puesto']?>); });
		$.get('obtener_options.php',{ tipo: "sucursales" }, function(data){ $("#s_sucursal").html(data); $('#s_sucursal').val(<?php echo $registro['id_sucursal']?>); });
		$.get('obtener_options.php',{ tipo: "deptos" }, function(data){ $("#s_deptos").html(data); $('#s_deptos').val(<?php echo $registro['id_depto']?>); });
		$.get('obtener_options.php',{ tipo: "estados" }, function(data){ $("#s_estados").html(data); $('#s_estados').val(<?php echo $registro['cve_estado']?>); 
		$.get('obtener_options.php',{ tipo: "municipios", estado: $("#s_estados").val() }, function(data) {$("#s_municipios").html(data); $('#s_municipios').val(<?php echo $registro['cve_municipio']?>); });  });	
		$.get('obtener_options.php',{ tipo: "documentos" }, function(data){ $("#s_doctype").html(data);  });	
		
		$('.no_mostrar').hide();
		$('.boton').button();
		$( ".vinetas" ).tabs();
		$('#save').hide();
		$('#upload').hide();
		$('.entradas').hide();
		//$('#edit').hide();
		
		$('#i_files').change(function(){archivo_cambio=1;});
		
		if( nivel == 2 )
			$('#edit').hide();
		else
			$('#edit').show();
			
		$('#edit').click(function(){
			$('#edit').hide(500);
			$('#save').show(500);
			$('#upload').show(500);
			
			//cambiar los datos por inputs
			$('.dato').hide();
			$('.entradas').show();
		});
		$('#upload').click(function(){
			$("#d_subir_doc").show(500);
		});
		$('#cancel').click(function(){
			$("#d_subir_doc").hide(500);
		});
		$('#back').click(function(){
			history.go(-1);
		});
		$('#save').click(function(){
			$('#forma').submit();
		});
		
		$('#upload_file').click(function(){
			if(archivo_cambio == 1)
				$('#form_upload').submit();
			else
				alert("Selecciona un archivo");
			archivo_cambio = 0;
		});
		
		$("#documentos").hide();
		$("#d_subir_doc").hide();
		
		$(".docs").click(function(){

				$("#documentos iframe").attr('src',$(this).attr('alt'));
				$("#documentos").show("slow");
			});
		$("#documentos").click(function(){
			$("#documentos").hide("slow");
		});
		
		$("#s_estados").change(function(){
				$.get('obtener_options.php',{ tipo: "municipios", estado: $("#s_estados").val() }, function(data) {$("#s_municipios").html(data); });							 
			});
			
		$(".borrar").click(function(){
				$.get('borrar_archivo.php',{ id: "<?php echo $id_trabajador ?>", doc: $(this).attr('title') }, function(data) {alert(data); location.reload(); });							 
			});
		$('#b_regresar').click(function(){
			history.back(1);
		});
	});
</script>

<body>
	<div id="transparencia">
			
		</div>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#" style="width: 100px;"></a>
	    </div>
	    <div>
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="#" id="b_regresar">Regresar</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<div class="vinetas">
		<ul>
			<li><a href="#tabs-1">Datos Trabajador</a></li>
			<li><a href="#tabs-2">Datos de Contacto</a></li>
			<li><a href="#tabs-3">Datos Personales</a></li>
			<li><a href="#tabs-4">Documentos</a></li>
			<?php
			if(($permisos == '3')||($permisos == '1'))
			{
			echo "<li><a href='#tabs-5'>Antidoping</a></li>";
			}
			if(($permisos == '3')||($permisos == '2'))
			{
			echo "<li><a href='#tabs-6'>Cursos</a></li>";
			}
			?>
		</ul>
			<form id="forma" action='editar_trabajador.php?id=<?php echo $id_trabajador ?>' method='post'>
				<div id="tabs-1">
					<center>
						<table>
							<tr>
								<td class='etiqueta'>Nombre:</td>
								<td><p class="dato"><?php echo utf8_encode($registro['nombre']); ?></p><input name="nombre"  class="entradas" value="<?php echo utf8_encode($registro['nombre']); ?>"/></td>
								<td colspan="2" rowspan="5" style="text-align:center"><img width="150" src="../docs/<?php echo $id_trabajador ?>/foto.jpg" /></td>
							</tr>
							<tr>
								<td class='etiqueta'>Apellido Paterno:</td>
								<td><p class="dato"><?php echo utf8_encode($registro['apellido_p']); ?></p><input name="apellido_p"  class="entradas" value="<?php echo utf8_encode($registro['apellido_p']); ?>"/></td>
							</tr>
							<tr>
								<td class='etiqueta'>Apellido Materno:</td>
								<td><p class="dato"><?php echo utf8_encode($registro['apellido_m']); ?></p><input name="apellido_m"  class="entradas" value="<?php echo utf8_encode($registro['apellido_m']); ?>"/></td>
							</tr>
							<tr>
								<td class='etiqueta'>Iniciales:</td>
								<td><p class="dato"><?php echo $registro['iniciales'] ?></p><input name="iniciales"  class="entradas" value="<?php echo $registro['iniciales'] ?>"/></td>
							</tr>
							<tr>
								<td class='etiqueta'>Puesto:</td>
								<td><p class="dato"><?php echo $registro['puesto'] ?></p><select name="id_puesto" id="s_puestos"  class="entradas"></select></td>
							</tr>
							<tr>
								<td class='etiqueta'>Departamento:</td>
								<td><p class="dato"><?php echo $registro['des_dep'] ?></p><select name="id_depto" id="s_deptos"  class="entradas"></select></td>
								<td colspan="2"></td>
							</tr>
							<tr>
								<td class='etiqueta'>Sucursal:</td>
								<td><p class="dato"><?php echo $registro['descr'] ?></p><select name="id_sucursal" id="s_sucursal"  class="entradas"></select></td>
								<td class="etiqueta">Fecha Ingreso:</td>
								<td><p class="dato"><?php echo $registro['fecha_ingreso'] ?></p><input name="fecha_ingreso"  class="entradas" value="<?php echo $registro['fecha_ingreso'] ?>"/ readonly></td>
							</tr>
							<tr>
								<td class='etiqueta'>NSS:</td>
								<td><p class="dato"><?php echo $registro['imss'] ?></p><input name="imss"  class="entradas" value="<?php echo $registro['imss'] ?>"/></td>
								<td class="etiqueta">Fecha Baja:</td>
								<td><p class="dato"><?php echo $registro['fecha_baja'] ?></p><input name="fecha_baja"  class="entradas" value="<?php echo $registro['fecha_baja'] ?>"/ readonly></td>
							</tr>
							<tr>
								<td class='etiqueta'>CURP:</td>
								<td><p class="dato"><?php echo $registro['curp'] ?></p><input name="curp"  class="entradas" value="<?php echo $registro['curp'] ?>"/></td>
								<td class="etiqueta">Reingreso:</td>
								<td><p class="dato"><?php echo $registro['reingreso'] ?></p><input name="reingreso"  class="entradas" value="<?php echo $registro['reingreso'] ?>"/ readonly></td>
							</tr>
						</table>
					<center>
				</div>
				<div id="tabs-2">
					<center>
						<table>
							<tr>
								<td class="etiqueta">Direccion:</td>
								<td><p class="dato"><?php echo utf8_encode($registro['direccion']); ?></p><input name="direccion"  class="entradas" value="<?php echo utf8_encode($registro['direccion']); ?>"/></td>
								<td class="etiqueta">Telefono1:</td>
								<td><p class="dato"><?php echo $registro['telefono1'] ?></p><input name="telefono1"  class="entradas" value="<?php echo $registro['telefono1'] ?>"/></td>
							</tr>
							<tr>
								<td class="etiqueta">Colonia:</td>
								<td><p class="dato"><?php echo utf8_encode($registro['colonia']); ?></p><input name="colonia"  class="entradas" value="<?php echo utf8_encode($registro['colonia']); ?>"/></td>
								<td class="etiqueta">Telefono2:</td>
								<td><p class="dato"><?php echo $registro['telefono2'] ?></p><input name="telefono2"  class="entradas" value="<?php echo $registro['telefono2'] ?>"/></td>
							</tr>
							<tr>
								<td class="etiqueta">Estado:</td>
								<td><p class="dato"><?php echo utf8_encode($registro['estado']); ?></p><select name="cve_estado" class="entradas" id="s_estados"></select></td>
								<td class="etiqueta">Correo:</td>
								<td><p class="dato"><?php echo $registro['correo'] ?></p><input name="correo"  class="entradas" value="<?php echo $registro['correo'] ?>"/></td>
							</tr>
							<tr>
								<td class="etiqueta">Municipio:</td>
								<td><p class="dato"><?php echo utf8_encode($registro['municipio']); ?></p><select name="cve_municipio"  class="entradas" id="s_municipios"></select></td>
								<td class="etiqueta">CP:</td>
								<td><p class="dato"><?php echo $registro['codigo_p'] ?></p><input name="codigo_p"  class="entradas" value="<?php echo $registro['codigo_p'] ?>"/></td>
							</tr>
						</table>
					</center>
				</div>
				<div id="tabs-3">
					<center>
						<table>
							<tr>
								<td class="etiqueta">Lugar de Nacimiento:</td>
								<td><p class="dato"><?php echo $registro['lugar_n'] ?></p><input name="lugar_n"  class="entradas" value="<?php echo $registro['lugar_n'] ?>"/></td>
								<td class="etiqueta">Fecha de Nacimiento:</td>
								<td><p class="dato"><?php echo $registro['anio_n']."/".$registro['mes_n']."/".$registro['dia_n'] ?></p><input name="anio_n"  class="entradas input_corta" value="<?php echo $registro['anio_n'] ?>"/><input name="mes_n"  class="entradas input_corta" value="<?php echo $registro['mes_n'] ?>"/><input name="dia_n"  class="entradas input_corta" value="<?php echo $registro['dia_n'] ?>"/></td>
							</tr>
							<tr>
								<td class="etiqueta">Nacionalidad:</td>
								<td><p class="dato"><?php echo $registro['nacionalidad'] ?></p><input name="nacionalidad"  class="entradas" value="<?php echo $registro['nacionalidad'] ?>"/></td>
								<td class="etiqueta">Sexo:</td>
								<td><p class="dato"><?php echo $registro['sexo'] ?></p><input name="sexo"  class="entradas" value="<?php echo $registro['sexo'] ?>"/></td>
							</tr>
							<tr>
								<td class="etiqueta">Peso:</td>
								<td><p class="dato"><?php echo $registro['peso'] ?></p><input name="peso"  class="entradas" value="<?php echo $registro['peso'] ?>"/></td>
								<td class="etiqueta">Estatura:</td>
								<td><p class="dato"><?php echo $registro['estatura'] ?></p><input name="estatura"  class="entradas" value="<?php echo $registro['estatura'] ?>"/></td>
							</tr>
							<tr>
								<td class="etiqueta">Experiencia:</td>
								<td><p class="dato"><?php echo $registro['experiencia'] ?></p><input name="experiencia"  class="entradas" value="<?php echo $registro['experencia'] ?>"/></td>
								<td class="etiqueta">Años Exp:</td>
								<td><p class="dato"><?php echo $registro['anos_exp'] ?></p><input name="anos_exp"  class="entradas" value="<?php echo $registro['anos_exp'] ?>"/></td>
							</tr>
							<tr>
								<td class="etiqueta">Estado Civil:</td>
								<td><p class="dato"><?php echo $registro['estado_c'] ?></p><input name="estado_c"  class="entradas" value="<?php echo $registro['estado_c'] ?>" /></td>
								<td class="etiqueta">Escolaridad:</td>
								<td><p class="dato"><?php echo $registro['escolaridad'] ?></p><input name="escolaridad"  class="entradas" value="<?php echo $registro['escolaridad'] ?>"/></td>
							</tr>
							<tr>
								<td class="etiqueta">Vive con:</td>
								<td><p class="dato"><?php echo $registro['vivecon'] ?></p><input name="vivecon"  class="entradas" value="<?php echo $registro['vivecon'] ?>"/></td>
								<td class="etiqueta"></td>
								<td></td>
							</tr>
							<tr><td colspan="4"><hr /></td></tr>
							<tr>
								<td class="etiqueta">Nombre Esposa:</td>
								<td><p class="dato"><?php echo utf8_encode($registro['nom_esposa']); ?></p><input name="nom_esposa"  class="entradas" value="<?php echo utf8_encode($registro['nom_esposa']); ?>"/></td>
								<td class="etiqueta">Trabajo Esposa:</td>
								<td><p class="dato"><?php echo utf8_encode($registro['trabajo_esposa']); ?></p><input name="trabajo_esposa"  class="entradas" value="<?php echo utf8_encode($registro['trabajo_esposa']); ?>"/></td>
							</tr>
							<tr>
								<td class="etiqueta">Telefono Esposa:</td>
								<td><p class="dato"><?php echo $registro['tel_esposa'] ?></p><input name="tel_esposa"  class="entradas" value="<?php echo $registro['tel_esposa'] ?>"/></td>
								<td class="etiqueta"></td>
								<td></td>
							</tr>
							<tr>
								<td class="etiqueta">Dependientes Menores:</td>
								<td><p class="dato"><?php echo $registro['dependientes_menores'] ?></p><input name="dependientes_menores"  class="entradas" value="<?php echo $registro['dependientes_menores'] ?>"/></td>
								<td class="etiqueta">Dependientes Mayores:</td>
								<td><p class="dato"><?php echo $registro['dependientes_mayores'] ?></p><input name="dependientes_mayores"  class="entradas" value="<?php echo $registro['dependientes_mayores'] ?>"/></td>
							</tr>
							<tr>
								<td class="etiqueta">Numero Hijos:</td>
								<td><p class="dato"><?php echo $registro['num_hijos'] ?></p><input name="num_hijos"  class="entradas" value="<?php echo $registro['num_hijos'] ?>"/></td>
								<td class="etiqueta"></td>
								<td></td>
							</tr>
							<tr><td colspan="4"><hr /></td></tr>
						</table>
					</center>
				</div>
				</form>
				<div id="tabs-4">
					<table style="width:60%;">
						<?php
							$query2 = "SELECT * FROM documentos_fijos WHERE id_trabajador = $id_trabajador";
							$resul = mysqli_query($link,$query2);
							$row = mysqli_fetch_array($resul);
							//echo $nivel_user;
						?>
						<tr class='<?php if(($nivel_user == '2') && (trim($row["alta_imss"])=="no")) echo "no_mostrar";?>'>						
						<td class="etiqueta">Alta IMSS:</td>
						<td class="datos"><?php if(trim($row["alta_imss"])!="no"){echo "Capturada"; }else{ echo "Sin Capturar"; }?></td>
						<td><?php if(trim($row["alta_imss"])!='no')echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/" . substr($row["alta_imss"], strpos($row["alta_imss"], 'docs')) . "' /><button class='boton entradas borrar' title='alta_imss'>borrar</button>";?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["contrato_ind"])=="no")) echo "no_mostrar";?>'>						
						<td class="etiqueta">Contrato Indeterminado:</td>
						<td class="datos"><?php if(trim($row["contrato_ind"])!="no"){echo "Capturada"; }else{ echo "Sin Capturar"; }?></td>
						<td><?php if(trim($row["contrato_ind"])!='no')echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["contrato_ind"], strpos($row["contrato_ind"], 'docs')) . "' /><button class='boton entradas borrar' title='contrato_ind'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["estudio_socioeconomico"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Estudio Socioeconomico:</td>
						<td class="datos"><?php if(trim($row["estudio_socioeconomico"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["estudio_socioeconomico"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["estudio_socioeconomico"], strpos($row["estudio_socioeconomico"], 'docs'))  ."' /><button class='boton entradas borrar' title='estudio_socioeconomico'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["antidoping"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Antidoping:</td>
						<td class="datos"><?php if(trim($row["antidoping"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["antidoping"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["antidoping"], strpos($row["antidoping"], 'docs')) ."' /><button class='boton entradas borrar' title='antidoping'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["carta_no_antecedentes"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Carta No Antecedentes:</td>
						<td class="datos"><?php if(trim($row["carta_no_antecedentes"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["carta_no_antecedentes"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["carta_no_antecedentes"], strpos($row["carta_no_antecedentes"], 'docs')) ."' /><button class='boton entradas borrar' title='carta_no_antecedentes'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if($psico == '0') echo "no_mostrar"; else if(($nivel_user == '2') && (trim($row["examen_psicometrico"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Examen Psicometrico:</td>
						<td class="datos"><?php if(trim($row["examen_psicometrico"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["examen_psicometrico"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["examen_psicometrico"], strpos($row["examen_psicometrico"], 'docs')) ."' /><button class='boton entradas borrar' title='examen_psicometrico'>borrar</button>"; ?></td>
						</tr>				
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["acta_nacimiento"])=="no")) echo "no_mostrar";?>'>						
						<td class="etiqueta">Acta Nacimiento:</td>
						<td class="datos"><?php if(trim($row["acta_nacimiento"])!="no"){echo "Capturada"; }else{ echo "Sin Capturar"; }?></td>
						<td><?php if(trim($row["acta_nacimiento"])!='no')echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/" . substr($row["acta_nacimiento"], strpos($row["acta_nacimiento"], 'docs')) . "' /><button class='boton entradas borrar' title='acta_nacimiento'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["identificacion_foto"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta" >Identificacion Foto:</td>
						<td class="datos"><?php if(trim($row["identificacion_foto"])!="no")echo "Capturada"; else echo "Sin Capturar";?></td>
						<td><?php if(trim($row["identificacion_foto"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/" .substr($row["identificacion_foto"], strpos($row["identificacion_foto"], 'docs'))   ."' /><button class='boton entradas borrar' title='identificacion_foto'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["comprobante_estudios"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Comprobante Estudios:</td>
						<td class="datos"><?php if(trim($row["comprobante_estudios"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["comprobante_estudios"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["comprobante_estudios"], strpos($row["comprobante_estudios"], 'docs'))."' /><button class='boton entradas borrar' title='comprobante_estudios'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["cartilla"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Cartilla Militar:</td>
						<td class="datos"><?php if(trim($row["cartilla"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["cartilla"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".  substr($row["cartilla"], strpos($row["cartilla"], 'docs')) ."'/><button class='boton entradas borrar' title='cartilla'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["carta_recomendacion1"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Carta Recomendacion 1:</td>
						<td class="datos"><?php if(trim($row["carta_recomendacion1"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["carta_recomendacion1"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".  substr($row["carta_recomendacion1"], strpos($row["carta_recomendacion1"], 'docs'))  ."' /><button class='boton entradas borrar' title='carta_recomendacion1'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["carta_recomendacion2"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Carta Recomendacion 2:</td>
						<td class="datos"><?php if(trim($row["carta_recomendacion2"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["carta_recomendacion2"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["carta_recomendacion2"], strpos($row["carta_recomendacion2"], 'docs'))  ."' /><button class='boton entradas borrar' title='carta_recomendacion2'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["curp"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">CURP:</td>
						<td class="datos"><?php if(trim($row["curp"])!="no") echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if (trim($row["curp"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".  substr($row["curp"], strpos($row["curp"], 'docs')) ."' /><button class='boton entradas borrar' title='curp'>borrar</button>";?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["comprobante_domicilio"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta" >Comprobante de Domicilio:</td>
						<td class="datos"><?php if(trim($row["comprobante_domicilio"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["comprobante_domicilio"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["comprobante_domicilio"], strpos($row["comprobante_domicilio"], 'docs')) ."' /><button class='boton entradas borrar' title='comprobante_domicilio'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["solicitud_empleo"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Solicitud Empleo:</td>
						<td class="datos"><?php if(trim($row["solicitud_empleo"])!="no")echo "Capturada"; else echo "Sin Capturar";?></td>
						<td><?php if(trim($row["solicitud_empleo"])!="no")echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".substr($row["solicitud_empleo"], strpos($row["solicitud_empleo"], 'docs'))."'/><button class='boton entradas borrar' title='solicitud_empleo'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["historial_empleo"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Historial Empleo:</td>
						<td class="datos"><?php if(trim($row["historial_empleo"])!="no") echo "Capturada"; else echo "Sin Capturar";  ?></td>
						<td><?php if(trim($row["historial_empleo"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".substr($row["historial_empleo"], strpos($row["historial_empleo"], 'docs'))."'/><button class='boton entradas  borrar' title='historial_empleo'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["carta_no_demanda"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Carta de no demandas:</td>
						<td class="datos"><?php if(trim($row["carta_no_demanda"])!="no") echo "Capturada"; else echo "Sin Capturar";  ?></td>
						<td><?php if(trim($row["carta_no_demanda"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".substr($row["carta_no_demanda"], strpos($row["carta_no_demanda"], 'docs'))."'/><button class='boton entradas  borrar' title='carta_no_demanda'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["foto_fed_1"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Foto de Frente:</td>
						<td class="datos"><?php if(trim($row["foto_fed_1"])!="no") echo "Capturada"; else echo "Sin Capturar";  ?></td>
						<td><?php if(trim($row["foto_fed_1"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["foto_fed_1"], strpos($row["foto_fed_1"], 'docs')) ."'/><button class='boton entradas  borrar' title='foto_fed_1'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["foto_fed_2"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Foto de Perfil Derecho:</td>
						<td class="datos"><?php if(trim($row["foto_fed_2"])!="no") echo "Capturada"; else echo "Sin Capturar";  ?></td>
						<td><?php if(trim($row["foto_fed_2"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["foto_fed_2"], strpos($row["foto_fed_2"], 'docs')) ."'/><button class='boton entradas  borrar' title='foto_fed_2'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["foto_fed_3"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Foto de Perfil Izquierdo:</td>
						<td class="datos"><?php if(trim($row["foto_fed_3"])!="no") echo "Capturada"; else echo "Sin Capturar";  ?></td>
						<td><?php if(trim($row["foto_fed_3"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".  substr($row["foto_fed_3"], strpos($row["foto_fed_3"], 'docs'))  ."'/><button class='boton entradas  borrar' title='foto_fed_3'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["cuip"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">CUIP:</td>
						<td class="datos"><?php if(trim($row["cuip"])!="no") echo "Capturada"; else echo "Sin Capturar";  ?></td>
						<td><?php if(trim($row["cuip"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["cuip"], strpos($row["cuip"], 'docs'))   ."'/><button class='boton entradas  borrar' title='cuip'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["modo_honesto"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Modo Honesto de Vivir:</td>
						<td class="datos"><?php if(trim($row["modo_honesto"])!="no") echo "Capturada"; else echo "Sin Capturar";  ?></td>
						<td><?php if(trim($row["modo_honesto"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".  substr($row["modo_honesto"], strpos($row["modo_honesto"], 'docs'))  ."'/><button class='boton entradas  borrar' title='modo_honesto'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["certificado_impedimento_fisico"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Certificado de no Impedimento Fisico:</td>
						<td class="datos"><?php if(trim($row["certificado_impedimento_fisico"])!="no") echo "Capturada"; else echo "Sin Capturar";  ?></td>
						<td><?php if(trim($row["certificado_impedimento_fisico"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".substr($row["certificado_impedimento_fisico"], strpos($row["certificado_impedimento_fisico"], 'docs')) ."'/><button class='boton entradas  borrar' title='certificado_impedimento_fisico'>borrar</button>"; ?></td>
						</tr>
												
						<tr class='<?php if($psico == '0') echo "no_mostrar"; else if(($nivel_user == '2') && (trim($row["dictamen_psicometrico"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Valoracion Psicometrica:</td>
						<td class="datos"><?php if(trim($row["dictamen_psicometrico"])!="no") echo "Capturada"; else echo "Sin Capturar";  ?></td>
						<td><?php if(trim($row["dictamen_psicometrico"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["dictamen_psicometrico"], strpos($row["dictamen_psicometrico"], 'docs')) ."'/><button class='boton entradas  borrar' title='dictamen_psicometrico'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["entrevista"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Entrevista:</td>
						<td class="datos"><?php if(trim($row["entrevista"])!="no") echo "Capturada"; else echo "Sin Capturar";  ?></td>
						<td><?php if(trim($row["entrevista"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["entrevista"], strpos($row["entrevista"], 'docs')) ."'/><button class='boton entradas  borrar' title='entrevista'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["cedula_municipal"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Cedula Municipal:</td>
						<td class="datos"><?php if(trim($row["cedula_municipal"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["cedula_municipal"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["cedula_municipal"], strpos($row["cedula_municipal"], 'docs')) ."' /><button class='boton entradas borrar' title='cedula_municipal'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["cedula_ingreso"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Cedula Ingreso:</td>
						<td class="datos"><?php if(trim($row["cedula_ingreso"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["cedula_ingreso"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".  substr($row["cedula_ingreso"], strpos($row["cedula_ingreso"], 'docs')) ."' /><button class='boton entradas borrar' title='cedula_ingreso'>borrar</button>"; ?></td>
						</tr>
						
						<tr class='<?php if(($nivel_user == '2') && (trim($row["documento_nuevo_ingreso"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Documento Nuevo Ingreso:</td>
						<td class="datos"><?php if(trim($row["documento_nuevo_ingreso"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["documento_nuevo_ingreso"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["documento_nuevo_ingreso"], strpos($row["documento_nuevo_ingreso"], 'docs'))."' /><button class='boton entradas borrar' title='documento_nuevo_ingreso'>borrar</button>"; ?></td>
						</tr>

						<tr class='<?php if(($nivel_user == '2') && (trim($row["aviso_retencion_infonavit"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Aviso Retencion Infonavit:</td>
						<td class="datos"><?php if(trim($row["aviso_retencion_infonavit"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["aviso_retencion_infonavit"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".substr($row["aviso_retencion_infonavit"], strpos($row["aviso_retencion_infonavit"], 'docs'))."' /><button class='boton entradas borrar' title='aviso_retencion_infonavit'>borrar</button>"; ?></td>
						</tr>

						<tr class='<?php if(($nivel_user == '2') && (trim($row["aviso_suspencion_retencion_infonavit"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Aviso Suspención Retención Infonavit:</td>
						<td class="datos"><?php if(trim($row["aviso_suspencion_retencion_infonavit"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["aviso_suspencion_retencion_infonavit"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["aviso_suspencion_retencion_infonavit"], strpos($row["aviso_suspencion_retencion_infonavit"], 'docs')) ."' /><button class='boton entradas borrar' title='aviso_suspencion_retencion_infonavit'>borrar</button>"; ?></td>
						</tr>

						<tr class='<?php if(($nivel_user == '2') && (trim($row["baja_imss"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Baja IMSS:</td>
						<td class="datos"><?php if(trim($row["baja_imss"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["baja_imss"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/". substr($row["baja_imss"], strpos($row["baja_imss"], 'docs'))  ."' /><button class='boton entradas borrar' title='baja_imss'>borrar</button>"; ?></td>
						</tr>

						<tr class='<?php if(($nivel_user == '2') && (trim($row["caratula_finiquito"])=="no")) echo "no_mostrar";?>'>
						<td class="etiqueta">Carátula Finiquito:</td>
						<td class="datos"><?php if(trim($row["caratula_finiquito"])!="no")echo "Capturada"; else echo "Sin Capturar"; ?></td>
						<td><?php if(trim($row["caratula_finiquito"])!="no") echo "<img class='docs' src='../images/icono-pdf.png' width='40' alt='../../../Portal/".  substr($row["caratula_finiquito"], strpos($row["caratula_finiquito"], 'docs'))  ."' /><button class='boton entradas borrar' title='caratula_finiquito'>borrar</button>"; ?></td>
						</tr>	
						
					</table>
				</div>
				<?php
				if(($permisos == '1')||($permisos == '3'))
				{
					echo "<div id='tabs-5'>";
										
					TablaQuery("SELECT a.fecha AS FECHA,b.tipo_examen AS EXAMEN,CASE a.negativo WHEN 2 THEN 'negativo' WHEN 1 THEN 'positivo' END AS RESULTADO 
									FROM antidopings a 
									LEFT JOIN cat_antidopings b ON a.id_tipo_examen = b.id_tipo_examen  
									WHERE a.id_trabajador = $id_trabajador",$link,"Antidopings");
					
					echo "</div>";
				}
				if(($permisos == '3')||($permisos == '2'))
				{
				echo "<div id='tabs-6'>";
					
					TablaQuery("SELECT a.fecha AS FECHA,b.nom_curso AS 'NOMBRE CURSO',a.capacitador AS CAPACITADOR
									FROM cursos a 
									LEFT JOIN cat_cursos b ON a.id_nom_curso = b.id_nom_curso  
									WHERE a.id_trabajador = $id_trabajador
									ORDER BY fecha DESC",$link,"Cursos");
				echo "</div>";
				}
				?>
				
				
			<center>	
				
			
				<button id="back" class="boton">Regresar</button>
				
				<button id="edit" class="boton <?php if($nivel_user == '2') echo "no_mostrar";?>">Editar</button>
				
				<!--
				<button id="save" class="boton <?php if($nivel_user == '2') echo "no_mostrar";?>">Guardar</button>
				-->
				<button id="upload" class="boton <?php if($nivel_user == '2') echo "no_mostrar";?>">Subir Archivo</button>
			</center>
			<br />	
			
	</div>
	<div id="documentos">
			<iframe src=""></iframe>
	</div>	
	<div id="d_subir_doc">
		<center>
			<form id="form_upload" action="subir_archivo.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id_trabajador ?>" />
				<h2>Indicar el archivo, y el tipo de archivo que se esta subiendo al sistema</h2>
				<input name="doc" type="file" id="i_files"/>
				<br />
				<select name="doctype" id="s_doctype"></select>
				<br />
				<br />
			</form>
				<button id="cancel" class="boton">Cancelar</button>
				<button id="upload_file" class="boton">Subir Archivo</button>
			
		</center>
	</div>
</body>
</html>
