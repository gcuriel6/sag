<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Horarios-Incidencias</title>
<link rel="icon" href="imagenes/favicon.ico">
</head>


	<link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
	<link rel="stylesheet" href="css/datepicker.css" />
	<link rel="stylesheet" href="css/general.css" />
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/alert.js"></script>
	<script src="js/dashboard.js"></script>
	

<script>
	var id_trabajador = 0;
	
	var id_depto = 0;
	$(function() {
	
		AnimateDB('0',45,23,'1');
		
		function llenaTrabajador(dato){
			
			AnimateDB('>',30,20);
			var html = "<table class='table-striped' id='t_trabajador'><thead><tr><td colspan='2'>Datos Trabajador</td></tr></thead><tbody></tbody></table>"; 
			$('#box1').html(html);
			html = "<tr><td class='der'>Id:</td><td>"+dato.id_empleado+"</td></tr>";
			html+= "<tr><td class='der'>Nombre:</td><td>"+dato.nombre+"</td></tr>";
			html+= "<tr><td class='der'>ApellidoP: </td><td>"+dato.apellido_p+"</td></tr>";
			html+= "<tr><td class='der'>ApellidoM: </td><td>"+dato.apellido_m+"</td></tr>";
			html+= "<tr><td class='der'>Depto: </td><td>"+dato.cve_dep+" "+dato.des_dep+"</td></tr>";
			html+= "<tr><td class='der'>Sucursal: </td><td>"+dato.sucursal+"</td></tr>";
			html+= "<tr><td class='der'>Ingreso: </td><td>"+dato.fecha_ingreso+"</td></tr>";
			html+= "<tr><td class='der'>Baja: </td><td>"+dato.fecha_baja+"</td></tr>";
			html+= "<tr><td class='der'><br>Sueldo: </td><td><br>"+dato.sueldo+"</td></tr>";
			$('#t_trabajador tbody').append(html);
			llenaRol();
			llenaIncidencias();
		}
		
		function llenaRol(){
			var html = "<table class='table-striped' id='t_rol'><thead><tr><td>depto</td><td>puesto</td><td>cadena</td></tr></thead><tbody></tbody></table>"; 
			$('#box2').html(html);
			
			$.post('php/busca_rol_trabajador.php',{'id_empleado':id_trabajador},function(data){
				var datos = JSON.parse(data);
				var num = datos[0];
				
				for(var i=1;i<=num;i++){
					var dato = datos[i];
					
					var html = "<tr><td>"+dato.cve_dep+" "+dato.depto+"</td><td>"+dato.puesto+"</td><td>"+dato.cadena+"</td></tr>";
					$('#t_rol tbody').append(html);
				}
			});
			
		}
		
		function llenaIncidencias(){
			var html = "<table class='table-striped' id='t_incidencia'><thead><tr><td>depto</td><td>fecha</td><td>incidencia</td><td>inc_aux</td></tr></thead><tbody></tbody></table>"; 
			$('#box4').html(html);
			
			$.post('php/busca_incidencias_trabajador.php',{'id_empleado':id_trabajador},function(data){
				
				var datos = JSON.parse(data);
				var num = datos[0];
				
				for(var i=1;i<=num;i++){
					var dato = datos[i];
					
					var html = "<tr><td>"+dato.cve_dep+" "+dato.des_dep+"</td><td>"+dato.fecha+"</td><td>"+dato.incidencia+"</td><td>"+dato.incidencia_aux+"</td></tr>";
					$('#t_incidencia tbody').append(html);
				}
				
			});
			
		}
		
		$('#i_id').change(function(){
			if($('#s_busqueda').val()=='1' && $(this).val() != '')
			$.post('php/busca_datos_empleado.php',{'parametro':'id','valor':$(this).val()},function(data){
				var datos = JSON.parse(data);
				var num = datos[0];
				if(num==1){
					var dato = datos[1];
					id_trabajador = dato.id_empleado;
					llenaTrabajador(dato);
				}
				
			});
			$('#i_nombre').val('');
			$('#i_id').val('');
		});
		
		$('#i_nombre').change(function(){
			if($('#s_busqueda').val()=='1' && $(this).val() != '')
			$.post('php/busca_datos_empleado.php',{'parametro':'nombre','valor':$(this).val()},function(data){
				var datos = JSON.parse(data);
				var num = datos[0];
				if(num==1){
					var dato = datos[1];
					id_trabajador = dato.id_empleado;
					llenaTrabajador(dato);
				}
				else{
					//alert(data);
					$('#t_trabajadores tbody').html('');
					for(var i = 1;i<=num;i++){
						var dato = datos[i];	
						var html = "<tr class='renglon_trabajador' alt='"+dato.id_empleado+"'><td>"+dato.id_empleado+"</td><td>"+dato.nombre+dato.apellido_p+dato.apellido_m+"</td><td>"+dato.des_dep+"</td><td>"+dato.sucursal+"</td><td>"+dato.fecha_ingreso+"</td><td>"+dato.fecha_baja+"</td></tr>";
						$('#t_trabajadores tbody').append(html);
					}
					$('#i_filtro_trabajador').val('');
					$('#modal_trabajadores').modal('show');
				}
			});
			$('#i_nombre').val('');
			$('#i_id').val('');
		});
		
		$('#modal_trabajadores').on('click','.renglon_trabajador',function(){
			id_trabajador = $(this).attr('alt');
			$.post('php/busca_datos_empleado.php',{'parametro':'id','valor':id_trabajador},function(data){
				var datos = JSON.parse(data);
				var num = datos[0];
				
				var dato = datos[1];
				id_trabajador = dato.id_empleado;
				llenaTrabajador(dato);
				
				$('#modal_trabajadores').modal('hide');
			});
		});
		
		$('#b_actualizar').click(function(){
			
				actualizaPantalla();
			
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
	});
</script>

<link rel="stylesheet" href="css/dashboard.css" type="text/css" media="all" />

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
	
	#d_busqueda {
			position: absolute;
			top: 5%;
			left: 5%;
			width: 90%;
			height: 10%;
			
			background-color: rgba(238,238,238,0.8);
			border-radius: 10px;
			-moz-box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
            box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
		
		}
	#t_busqueda{
		position: absolute;
		top: 20%;
		left: 2%;
		width: 86%;
		height: 2%;
	}
	
	#d_cuadros {
			position: absolute;
			top: 15%;
			left: 2%;
			width: 96%;
			bottom: 2%;
			
			background-color: rgba(1,1,1,0);
			
		
		}
		
	.box table{
		position: absolute;
		top: 2%;
		left: 2%;
		width: 96%;
		
	}
	thead tr td{
		background-color: rgba(0,0,0,0.8);
		color:#FFFFFF;
	}
</style>

<body>
	<div id="transparencia">
		
	</div>
	
	<div id="d_busqueda">		
		<table id="t_busqueda" >
			
			<tbody>
		<tr>
			<td>
				Busqueda:
				<select id="s_busqueda">
					<option value='1'>Empleado</option>
					<!--
					<option value='2'>Depto</option>
					-->
				</select>
			</td>
			<td>
				id:
				<input id="i_id" />
			</td>
			<td>
				nombre:
				<input id="i_nombre" />
			</td>
			<td>
				<!--
				<button type='button' class='btn btn-primary' id='b_actualizar'  ><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> Actualizar</button> 
				-->
			</td>
		</tr>
		</tbody>		
	</table>
	</div>
	
	<div id="d_cuadros">
		<div id="box1" class="box">
		
		</div>
		<div id="box2" class="box">
		
		</div>
		
		<div id="box3" class="box">
			
		</div>
		
		<div id="box4" class="box">
		
		</div>
	</div>
	
	<div class="modal fade" id="modal_trabajadores" tabindex="-1" role="dialog" aria-labelledby="modal_label_trabajadores" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modal_label_presupuesto">Trabajadores Encontrados</h4>
		      </div>
		      <div class="modal-body table-responsive">
		        <table id="t_trabajadores" class="table table-bordered">
		        	<thead>
		        		<tr>
		        			<td colspan="4">
		        				<input id="i_filtro_trabajador" class="ifiltro" tabla='t_trabajadores' />
		        			</td>
		        		</tr>
		        		<tr>
		        			<td>id</td>
		        			<td>nombre</td>
		        			<td>depto</td>
		        			<td>sucursal</td>
		        			<td>ingreso</td>
		        			<td>baja</td>
		        		</tr>
		        	</thead>
		        	<tbody>
		        		
		        	</tbody>
		        </table>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		      </div>
		    </div>
		  </div>
		</div>
</body>
</html>