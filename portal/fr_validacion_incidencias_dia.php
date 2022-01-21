<?php
	session_start();
	
	
	$validar = $_SESSION['validar'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Reporte de Incidencias</title>
	</head>

	
	<link rel="stylesheet" href="css/general.css" />
	<link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/general.js"></script>
	
	<script>
	
		var validar = <?php echo $validar ?>;
		
		$(document).ready(function() {
			
			$('#i_fecha').datepicker({
				format:'yyyy-mm-dd',
			}).on('changeDate', function(ev){
			    $(this).datepicker('hide');
			    llenaTabla();
			});
			
			
			function llenaTabla(){
				$.post('php/busca_incidencias_dia.php',{'fecha':$('#i_fecha').val()},function(data){
					
					var datos = JSON.parse(data);
					var num = datos[0];
					$('#t_incidencias_hoy>tbody').html('');
					for(var i = 1; i<= num ;i++){
						var dato = datos[i];
						var html ="<tr class='renglon_e' reg='"+dato.registro+"'><td colspan='7'><table>";
						
						if(dato.captura=='2')
							var color = 'rgba(230,230,230,0.90)';
						else
							var color = 'rgba(230,230,230,0.00)';
						
						if(dato.validado==0)
							html = html + "<tr class='renglon1' style='background-color:"+color+"'><td width='100'>"+dato.fecha+"</td><td width='200'>"+dato.depto+"</td><td width='300'>"+dato.trabajador+"</td><td width='200'>"+dato.puesto+"</td><td width='80'>"+dato.incidencia+"</td><td width='80'>"+dato.incidencia_aux+"</td><td rowspan='2' width='80'><button type='button' reg='"+dato.registro+"' class='btn btn-info b_validar'>Validar</button></td></tr>";
						else
							html = html + "<tr class='renglon1' style='background-color:"+color+"'><td width='100'>"+dato.fecha+"</td><td width='200'>"+dato.depto+"</td><td width='300'>"+dato.trabajador+"</td><td width='200'>"+dato.puesto+"</td><td width='80'>"+dato.incidencia+"</td><td width='80'>"+dato.incidencia_aux+"</td><td rowspan='2' width='80'><button type='button' reg='"+dato.registro+"' class='btn btn-warning b_desvalidar'>Desvalidar</button></td></tr>";
						
						html = html + "<tr class='renglon2'><td>SUPE: "+dato.super_ini+"</td><td colspan='5'>JUST:"+dato.justificacion+"</td><tr>";
						if(dato.incidencia1 != '')
						{
							
							var html = html+"<tr class='renglon3'><td colspan='2'>Reemp1: "+dato.reemp1+" ["+dato.incidencia1+"]</td>";
							
							if(dato.incidencia2 != '')
							var html = html + "<td>Reemp2: "+dato.reemp2+" ["+dato.incidencia2+"]</td>";
							if(dato.incidencia3 != '')
							var html = html + "<td>Reemp3: "+dato.reemp3+" ["+dato.incidencia3+"]</td>";
							
							var html = html + "</tr>";
	
						}
						
						html = html + "</table></td></tr>";
						$('#t_incidencias_hoy>tbody').append(html);
						
					}
					
					$('#contenido .btn').addClass('disabled');
				});
			}
			
			$.expr[':'].contains = $.expr.createPseudo(function(arg) {
				return function(elem) {
					return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
				};
			});
			
			$('.ifiltro').change(function() {
				var aux = $(this).val();
				
				var tabla = $(this).attr('tabla');
				var tabla = '#' + tabla;
				if (aux == '') {
					$(tabla + '>tbody>tr').show();
				} else {
					$(tabla + '>tbody>tr').hide();			
					$(tabla + '>tbody>tr>td:contains(' + aux + ')').parent().show();		
				}
			});
			
		});
	</script>

	<style>
		#t_incidencias_hoy{
			position:absolute;
			top:0px;
			left:0px;
			width: 100%;
		}
		
		.renglon_e table{
			
			width: 100%;
		}
		.renglon1{
			font-size:16px;
			color:#010101;
		}
		.renglon2{
			font-size:14px;
			color:#AAAAAA;
		}
		.renglon3{
			font-size:14px;
			color:red;
		}
		
		#d_datos{
			overflow: auto;
			height: 500px;
			
		}
		
	</style>

	<body>
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#" style="width: 100px;"></a>
		    </div>
		    <div>
		      <ul class="nav navbar-nav">
		        <li><a href="fr_validacion_incidencias.php">Hoy</a></li>
		        <li><a href="fr_validacion_incidencias_anteriores.php">Sin Validar</a></li>
		        <li class="active"><a href="fr_validacion_incidencias_dia.php">Busca Dia</a></li>
		        
		      </ul>
		    </div>
		  </div>
		</nav>
		<div id='contenido' class="container-fluid">
			<div class="row">
				<div class="col-md-3">
				</div>
				<div class="col-md-3">
					<br>
					Fecha: <input id="i_fecha" />
				</div>
				<div class="col-md-3" align="center">
					<br>
					
					Filtro: <input class="ifiltro" tabla = 't_incidencias_hoy' />
				</div>
				<div class="col-md-2" align="right">	
					<br>
					<button type='button' class='btn btn-info b_validar_todo'>Validar Todo</button></td>
					
					
				</div>
			</div>
			<div class="row">
				<br>
			</div>
			<div id="d_datos"  class="row">
				<div class="col-md-1">
				</div>
				<div class="col-md-10">
					<table class="table" id="t_incidencias_hoy">
						<thead>
							<tr class='info'>
								
								<td width='100'>Fecha</td>
								<td width='200'>Depto</td>
								<td width='300'>Trabajador</td>
								<td width='200'>Puesto</td>
								<td width='80'>Rol</td>
								<td width='80'>Inc</td>
								<td width='80'>Validar</td>
								
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
		
	</body>
</html>