<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Forma Departamentos</title>
<link rel="icon" href="imagenes/favicon.ico">
</head>


	<link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
	<link rel="stylesheet" href="css/datepicker.css" />
	<link rel="stylesheet" href="css/general.css" />
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/alert.js"></script>


<script>
	$(function() {
		$.post('php/obtener_options.php',{tipo:'sucursales'},function(data){	
			$('#s_sucursales').html(data);
			actualizaDeptos();
		});
		
		$('#b_nuevo').click(function(){
			var info = {'des_dep':$('#i_des_dep').val(),
						'servicio':$('#i_observacion').val(),
						'id_sucursal':$('#s_sucursales').val()
					};
			if($('#i_des_dep').val()!=''){
				
			
				$.post('php/crea_depto_nuevo.php',info,function(data){
					if(data==1){
						actualizaDeptos();
						mandarMensaje('Departamento Creado Correctamente');
						$('#i_des_dep').val('');
						$('#i_observacion').val('');
					}
					else{
						mandarMensajeError('Error:'+data);
					}
				});
			}else{
				mandarMensajeError('Debe indicar un Nombre al Departamento');
			}
		});
		
		$('#s_sucursales').change(function(){
			actualizaDeptos();
		});
		
		function actualizaDeptos(){
			$.post('php/busca_deptos.php',{sucursal:$('#s_sucursales').val()},function(data){	
				var datos = JSON.parse(data);
				var num = datos[0];
				var html = '';
				$("#t_departamentos tbody").html('');
				for(var i = 1; i<= num;i++){
					var dato = datos[i];
					if(dato.inactivo == 0){
						var activo = "S";
						var boton = "<button alt='"+dato.id_depto+"' class='btn btn-success b_inactivo'>S</button>";
					}	
					else{
						var activo = "N";
						var boton = "<button alt='"+dato.id_depto+"' class='btn btn-warning b_inactivo'>N</button>";
					}	
					
					if(dato.presupuesto == 1){
						var presupuesto = "S";
						var boton2 = "<button alt='"+dato.id_depto+"' class='btn btn-success b_presupuesto'>S</button>";
					}	
					else{
						var presupuesto = "N";
						var boton2 = "<button alt='"+dato.id_depto+"' class='btn btn-warning b_presupuesto'>N</button>";
					}	
					html = "<tr class='renglon_depto'><td>"+dato.cve_dep+"</td><td>"+dato.des_dep+"</td><td>"+dato.servicio+"</td><td class='td_inactivo' alt='"+activo+"'>"+boton+"</td><td class='td_presupuesto' alt='"+presupuesto+"'>"+boton2+"</td></tr>";
					$("#t_departamentos tbody").append(html);
				}
				filtrarDeptos();
			});
		}
		
		$('.filtro').change(function(){
			
				filtrarDeptos();
		});
		
		$("#t_departamentos").on('click','.b_inactivo',function(){
			
			if($(this).html()=='S')
				var opcion = 1;
			else
				var opcion = 0;
			$.post('php/cambia_estatus_depto.php',{'id_depto':$(this).attr('alt'),'opcion':opcion},function(data){
				if(data==1){
					actualizaDeptos();
				}
				else
					mandarMensaje('Ocurrio un error al cambiar estatus');
					//alert(data);
			});	
		});
		
		$("#t_departamentos").on('click','.b_presupuesto',function(){
			
			if($(this).html()=='S')
				var opcion = 0;
			else
				var opcion = 1;
			$.post('php/cambia_presupuesto_depto.php',{'id_depto':$(this).attr('alt'),'opcion':opcion},function(data){
				if(data==1){
					actualizaDeptos();
				}
				else
					alert(data);
			});	
		});
		
		function filtrarDeptos(){
			
			if($('#i_inactivos').is(':checked'))
				var inactivos = 1;
			else
				var inactivos = 0;
				
			if($('#i_presupuesto').is(':checked'))
				var presupuesto = 1;
			else
				var presupuesto = 0;
			
			$('.renglon_depto').hide();
			$('.renglon_depto').each(function(){
				if(inactivos==0){	
					if($(this).find('.td_inactivo').attr('alt')=='S'){
						if(presupuesto==1){
							if($(this).find('.td_presupuesto').attr('alt')=='N')
								$(this).show();
						}
						else
							$(this).show();	
					}
						
				}else{
					if(presupuesto==1){
							if($(this).find('.td_presupuesto').attr('alt')=='N')
								$(this).show();
						}
						else
							$(this).show();		
				}	
			});	
			
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

		}
		
		$('#b_regresar').click(function(){
			history.go(-1);
		});
	});
</script>

<style>
	body{
		background: #fefefe url('imagenes/trabajo1.jpg') no-repeat ;
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
	
	#contenido {
			position: absolute;
			top: 5%;
			left: 5%;
			width: 90%;
			bottom: 5%;
			
			background-color: rgba(238,238,238,0.8);
			border-radius: 10px;
			-moz-box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
            box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
		
		}
	#t_busqueda{
		position: absolute;
		top: 1%;
		left: 5%;
		width: 90%;
		height: 5%;
	}
	#div_cuerpo_presupuesto{
		position: absolute;
		bottom:15%;
		left: 5%;
		width: 90%;
		height: 73%;
		overflow: auto;
	}
	#d_nuevo{
		position: absolute;
		bottom:5%;
		left: 5%;
		width: 90%;
		height: 5%;
	}
	
</style>

<body>
	<div id="transparencia">
		
	</div>
	
	<div id="contenido">
		
			<table id="t_busqueda" >
				<tr>
					<td>
						Sucursal:
						<select id="s_sucursales">
					
						</select>
					</td>
					<td align="center"><input type="checkbox" class="filtro" id="i_inactivos" name="" value=""> Mostrar Inactivos</td>
					<td><input type="checkbox" id="i_presupuesto" class="filtro" name="" value=""> Mostrar solo los que NO estan en presupuesto</td>
					<td><button type="button" class="btn btn-primary " id="b_regresar"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>  REGRESAR</button></td>
				</tr>
				<tr>
					<td colspan="3">Filtro<input class="ifiltro" tabla='t_departamentos'></td>
				</tr>
			</table>
		
			<div id="div_cuerpo_presupuesto">
				
				<table class="table table-striped" id="t_departamentos"  >
					<thead>
					<tr class="encabezado" style="background-color:#f2f2f2;">
						<td width="5%">Clave</td>
						<td width="40%">Departamento</td>
						<td width="35%">Observacion</td>
						<td width="10%">Activo</td>
						<td width="10%">En presupuesto</td>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
											
			</div>
			<div id="d_nuevo">
				<!-- MGFS 10-01-2010 SE COMENTA EL DAR DE ALTA UN DEPARTAMENTO DESDE ATT HASTA SU ANALISIS-->
				<!--<table >
					<tr>
						<td width="50%;" align="">Nuevo Departamento:<input type="text" id="i_des_dep"   size="30"></td>
						<td width="50%;" align="center">Observacion:<input type="text" id="i_observacion"   size="40" style="margin-right: 2%;"></td>
						<td><button type="button" class="btn btn-primary " id="b_nuevo"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></td>
					</tr>
				</table>-->
					
			</div>
		
				
		
	</div>
</body>
</html>