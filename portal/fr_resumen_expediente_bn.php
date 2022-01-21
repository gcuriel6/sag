<?php
	
	session_start();
	include '../php/conectar.php';
	include("php/php_tools.php");
	
	$link = Conectarse();
	
	$user =  $_SESSION["usuario"];
	
	//obtener permisos de edicion o consulta
	$query = "SELECT id_sucursal,deptos,nivel_web FROM accesos WHERE usuario = '$user'";
	$resultado = mysqli_query($link,$query);
	$cont = 0;
	while($registro = mysqli_fetch_array($resultado))
	{
		$accesos[$cont][0] = $registro['id_sucursal'];
		$accesos[$cont][1] = $registro['deptos'];
		$accesos[$cont][2] = $registro['nivel_web'];
		$cont++;
	}
	//print_r ($accesos);
	//----------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Pragma" content="no-cache">
<title>Documento sin título</title>
</head>

<style>
	#vidrio	{
		position:relative;
		top:20px;
		left:5%;
		width:90%;
		height:85%;
		background-color:#EEE;
		opacity:0.5;
		border-radius:10px;
		overflow: auto;
	}
	input,label{border-radius:5px; padding:3px 10px; font-weight:bold;}
	#i_filtro{
		width:300px;
		z-index:0;
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
			z-index: -1;
		}
</style>


	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/general.js"></script>
	<script>
		$(function() {
			$.expr[':'].contains = $.expr.createPseudo(function(arg) {
				return function(elem) {
					return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
				};
			});
			
			$('.ifiltro').change(function() {
				var aux = $(this).val();
				var tabla = $(this).attr('tabla');
				var tabla = '.' + tabla;
				if (aux == '') {
					$(tabla + '>tbody>tr').show();
				} else {
					$(tabla + '>tbody>tr').hide();			
					$(tabla + '>tbody>tr>td:contains(' + aux + ')').parent().show();		
				}
			});
		});
	</script>
	<link rel="stylesheet" href="css/general.css" />
	<link rel="stylesheet" href="css/bootstrap/bootstrap.css" />

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
		        <li><a href="fr_resumen_expediente.php" target="_self">Expediente</a></li>
		        <li class="active"><a href="fr_resumen_expediente_b.php" target="_self">Bajas</a></li>  
		      </ul>
		    </div>
		  </div>
		</nav>
		<div id="busqueda">
			<center>
				<label for="i_buscar">Filtro:</label>
				<input id="i_filtro"  class="ifiltro" tabla="query_table"  type="text"/>
			</center>
			
		</div>
	<div id="vidrio">
		
		<?php 
			
			for($i = 0; $i < $cont;$i++)
			{

				if($accesos[$i][2] != 3)
				{
					
					$suc = $accesos[$i][0];
					$dep = $accesos[$i][1];
					
					$query = "SELECT descr FROM sucursales WHERE id_sucursal = '$suc'";
					$resultado = mysqli_query($link,$query);
					$registro = mysqli_fetch_array($resultado);
					
					$sucur = $registro["descr"];
					
					if(trim($dep) != '')
					{
					TablaQuery("SELECT a.id_trabajador AS id,CONCAT(a.apellido_p,' ',a.apellido_m,' ',a.nombre) AS 'nombre completo',b.puesto,c.des_dep AS 'departamento' ,c.cve_dep AS 'clave'
						FROM trabajadores a
						LEFT JOIN cat_puestos b ON a.id_puesto = b.id_puesto
						LEFT JOIN deptos c ON a.id_depto = c.id_depto
						WHERE a.id_sucursal = '$suc' AND a.id_depto IN ($dep) AND fecha_baja != '00-00-00' ",$link,"SUCURSAL $sucur","php/detalle_trabajador_bn.php","id","nombre completo");
					//echo "con";
					}
					else
					{

					TablaQuery("SELECT a.id_trabajador AS id,CONCAT(a.apellido_p,' ',a.apellido_m,' ',a.nombre) AS 'nombre completo',b.puesto,c.des_dep AS 'departamento' ,c.cve_dep AS 'clave'
						FROM trabajadores a
						LEFT JOIN cat_puestos b ON a.id_puesto = b.id_puesto
						LEFT JOIN deptos c ON a.id_depto = c.id_depto
						WHERE a.id_sucursal = '$suc' AND fecha_baja != '00-00-00'",$link,"SUCURSAL $sucur","php/detalle_trabajador_bn.php","id","nombre completo");
					//echo "sin";
					}
				}
			}
		?>
	</div>
	
</body>
</html>