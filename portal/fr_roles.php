<?php
	session_start();
	$id_supervisor = $_SESSION['id_supervisor'];
	$id_usuario = $_SESSION['id_usuario'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Forma Roles</title>
<link rel="icon" href="imagenes/favicon.ico">
</head>


	<link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
	<link rel="stylesheet" href="css/datepicker.css" />
	<link rel="stylesheet" href="css/general.css" />

	<link href="select2/css/select2.css" rel="stylesheet"/>

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap-datepicker-new.js"></script>
	<script src="js/alert.js"></script>
	<script src="select2/js/select2.js"></script>

<script>

	var id_supervisor=<?php echo $id_supervisor?>;
	let id_usuario = <?php echo $id_usuario?>;
	var dias_rol=0;
	var id_registro=0;
	var roles_depto={};
	var id_empleado = 0;
	let arregloPuedenEditar = [38,41,404,16,19,316,47,62,138,69,25,66,281,4,37,428,72];
	
	function difDates(fecha1,fecha2){
		var diff = Math.abs(new Date(fecha1)-new Date(fecha2));
		return diff/86400000;
	}
	
	function addZ(n){return n<10? '0'+n:''+n;}
	
	$(function() {

		 $("#s_departamentos").select2(); 
		
		$('.datepicker').datepicker({
				format:'yyyy-mm-dd',
				forceParse:true
		}).on('show', function(){		
					 	
					// Obtener valores actuales z-index de cada elemento
					var zIndexModal = 1041;
					var zIndexFecha = $('.datepicker').css('z-index');
				 
				        // alert(zIndexModal + zIndexFEcha);
				 
				        // Re asignamos el valor z-index para mostrar sobre la ventana modal
				        $('.datepicker').css('z-index',zIndexModal+1);
				       
					
			}).on('changeDate', function(ev){ 
				$(this).datepicker('hide');
			});
		
		$.post('php/obtener_options.php',{tipo:'puestos'},function(data){	
			$('#editar_puestos').html(data);
			$('#crear_puestos').html(data);
		});
		
		$.post('php/crea_dias_roles.php',{},function(data){
			$('#t_departamentos thead').html(data);
			dias_rol = $('.td_dia').length;
		});
		
		$.post('php/obtiene_deptos_supervisor.php',{id_supervisor:id_supervisor},function(data){	
			$('#s_departamentos').html(data);
			//alert('hace algo');
			obtiene_trabajadores();
			obtiene_no_asignados();
		});
		
		$('#s_departamentos').change(function(){
			obtiene_trabajadores();
			obtiene_no_asignados();
		});
		
		function obtiene_trabajadores(){
			$.post('php/busca_trabajadores.php',{id_departamento : $('#s_departamentos').val()},function(data){
				var datos = JSON.parse(data);
				var num = datos[0];
				var html = '';
				$("#t_departamentos tbody").html('');
				for(var i = 1; i<= num;i++){
					var dato = datos[i];
					var dia1 = dato.fecha_dia1;
					var cadena = dato.cadena;
					var tam = cadena.length;
					
					if(dato.id_depto==dato.id_depto_trab)
						html = "<tr class='renglon_trabajador' alt4='"+dato.id_registro+"' alt3='"+dato.id_depto+"'  alt='"+dato.id_trabajador+"' alt2='"+dato.difvacante+"'><td class='td_trab' width='12%'><h6>"+dato.nombre+"</6></td><td class='td_trab' width='16%'><h6>"+dato.descr+"</h6></td><td width='9%' class='td_puesto td_trab' alt='"+dato.id_puesto+"'>"+dato.posicion+"</td>";
					else
						html = "<tr class='renglon_trabajador fuera_depto' alt4='"+dato.id_registro+"' alt3='"+dato.id_depto+"'  alt='"+dato.id_trabajador+"' alt2='"+dato.difvacante+"'><td class='td_trab' width='12%'><h6>"+dato.nombre+"</6></td><td class='td_trab' width='16%'><h6>"+dato.descr+"</h6></td><td width='9%' class='td_puesto td_trab' alt='"+dato.id_puesto+"'>"+dato.posicion+"</td>";
					
					
					$('.td_dia').each(function(){
						var dia = $(this).attr('title');
						
						var piv = (difDates(dia,dia1)%tam);
						
						html = html+"<td>"+cadena[piv]+"</td>"
					});

					if(arregloPuedenEditar.includes(id_usuario) ){
						html = html + "<td><button type='button' class='btn btn-warning b_borrar'  alt='"+dato.id_registro+"'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button></td></tr>";
					}else{
						html = html + "<td></td></tr>";
					}
					
					$("#t_departamentos tbody").append(html);
				}
			});
			
			$.post('php/busca_presupuesto_actual_depto.php',{'id_depto':$('#s_departamentos').val()},function(data){
				var datos = JSON.parse(data);
				var num = datos[0];
				roles_depto={}
				for(var i=0;i<=num;i++){
					var dato = datos[i];

					var puesto = dato.puesto;
					var oficiales = dato.oficiales;
					if(typeof(roles_depto[puesto]) != "undefined")
						roles_depto[puesto]=roles_depto[puesto]+oficiales;
					else
						roles_depto[puesto]=oficiales;
				}
				
			});
			
		}

		if(arregloPuedenEditar.includes(id_usuario) ){
			$("#t_departamentos tbody").on('click','.td_trab',function(){
				id_empleado = $(this).parent().attr('alt');
				if(id_empleado == 0){
					$('#b_liberar_posicion').prop('disabled', true);
				}
				else{
					$('#b_liberar_posicion').prop('disabled', false);
				}
				var difvacante = $(this).parent().attr('alt2');
				var id_depto = $(this).parent().attr('alt3');
				$.post('php/busca_posicion_roles.php',{'id_empleado':id_empleado,'difvacante':difvacante,'id_depto':id_depto},function(data){
					var datos = JSON.parse(data);
					var cadena = datos.cadena;
					var tam = cadena.length;
					
					var dia1 = datos.fechadia1;
					$('#editar_puestos').val(datos.id_puesto);
					$('#i_descripcion').val(datos.descr);
					$('#i_horas').val(datos.dias);
					$('#i_cadena').val(datos.cadena);
					$('#span_crear_cadena2').html('');
					
					var aux = new Date();
					var hoy = aux.getFullYear()+'-'+addZ(aux.getMonth()+1)+'-'+addZ(aux.getDate());
					
					var pivote = (difDates(hoy,dia1)%tam)+1;
					
					id_registro = datos.id_registro;
					$('#i_pivote').val(pivote);
					
					
					$('#modal_edicion_rol').modal('show');
				});
			});

			$('#t_departamentos tbody').on('click','.b_borrar', function(e){
				id_registro = $(this).attr('alt');
			
				$('#modal_borrar_horario').modal('show');
			});

			$('#b_borrar_registro').click(function(){
				$.post('php/delete_incidencias_horario.php',{'id_registro':id_registro},function(data){
					if(data==1){
						$.post('php/borra_registro_horario.php',{'id_registro':id_registro},function(data2){
							if(data2==1){
								obtiene_trabajadores();
								obtiene_no_asignados();
								$('#modal_borrar_horario').modal('hide');
								mandarMensaje('Registro Borrado Correctamente');
							}else{
								mandarMensajeError('Error al borrar horario: '+data2);
							}
						});
					}
					else{
						mandarMensajeError('Error al borrar incidencias: '+data);
					}
					
						
				});
					
				
			});
		}else{
			console.log("tu no puedes");
		}
		
		function obtiene_no_asignados(){
			$.post('php/busca_no_asignados.php',{id_departamento:$('#s_departamentos').val()},function(data){
				var datos = JSON.parse(data);
				//alert(JSON.stringify(datos));
				var num = datos[0];
				var html = '';
				$("#t_no_asignado tbody").html('');
				for(var i=1;i<=num;i++){
					var dato = datos[i];
					html = "<tr class='tr_trabajador_no' alt='"+dato.id_trabajador+"'><td><h6>"+dato.nombre+"</h6></td></tr>";
					$("#t_no_asignado tbody").append(html);					
				}
			});
		}
		
		$("#t_no_asignado").on('click','.tr_trabajador_no',function(){
			var id_trab = $(this).attr('alt');
			$('#i_fecha_cambio_trabajador').val('');
			$.post('php/busca_trabajadores.php',{id_departamento : $('#s_departamentos').val()},function(data){
				var datos = JSON.parse(data);
				var num = datos[0];
				var html = '';
				$("#t_dialogo_cambiar_trabajador tbody").html('');
				for(var i = 1; i<= num;i++){
					var dato = datos[i];
					var html = "<tr><td>"+dato.nombre+"</td><td>"+dato.descr+"</td><td>"+dato.posicion+"</td><td><button alt1='"+dato.id_trabajador+"' alt3='"+dato.difvacante+"' alt2='"+id_trab+"' alt4='"+dato.id_registro+"' class='btn btn-success b_cambia_trabajador'>Sustituir</button></td></tr>";
					$("#t_dialogo_cambiar_trabajador tbody").append(html);
				}
				
				$('#modal_cambiar_trabajador').modal('show');
			});
		});
		
		$("#t_dialogo_cambiar_trabajador").on('click','.b_cambia_trabajador',function(){
			var id_trab = $(this).attr('alt1');
			var difvacante = $(this).attr('alt3');
			var id_trab2 = $(this).attr('alt2');
			var id_registro = $(this).attr('alt4');
			
			var info2 = {'id_empleado':id_trab,
						'difvacante':difvacante,
						'id_registro':id_registro};
						
			var info = {'id_trab1':id_trab,
						'difvacante':difvacante,
						'id_trab2':id_trab2,
						'id_depto':$('#s_departamentos').val()};
			
			
			$.post('php/cambia_trabajador_horario.php',info,function(data2){
				if(data2==1){
					$.post('php/update_incidencias_horario.php',info2,function(data){
						if(data==1){
							obtiene_trabajadores();
							obtiene_no_asignados();
							$('#modal_cambiar_trabajador').modal('hide');
							mandarMensaje('Posicion Editada Correctamente');
						}
						else{
							mandarMensajeError("Error al cambiar incidencias: "+data);
						}
					});
				}else{
					mandarMensajeError("Error al cambiar horario: "+data2);
				}
			});
				
		});
		
		function validaRoles(){
			var aux = {};
			$('.td_puesto').each(function(){
				var id_puesto = $(this).attr('alt');
				var puesto = $(this).html();
				if(typeof(aux[puesto]) != "undefined")
					aux[puesto]=aux[puesto]+1;
				else
					aux[puesto]=1;
			});
			//alert(JSON.stringify(aux));
			//alert(JSON.stringify(roles_depto));
			
			var keys = Object.keys(roles_depto);
			keys = keys.toString().replace("undefined,", "");
		 	keys = keys.split(",").sort();
		 	
		 	var keys2 = Object.keys(aux);
		 	//alert(keys2);
		 	keys2 = keys2.toString().split(",").sort();
		 	
		 	var keys3 = keys.concat(keys2);
			//alert(JSON.stringify(keys3));
			if(keys.length!=keys2.length){
				//Revisar cuales sobran.
				mandarMensajeError('No corresponden los puestos presupuestados, con los capturados en pantalla');
			}
			else{
				var cont = 0;
				for(var i = 0;i<keys3.length;i++){
					var llave = keys3[i];
					//alert(llave+'  '+parseInt(roles_depto[llave])+'  '+parseInt(aux[llave]));
					if(parseInt(roles_depto[llave])!=parseInt(aux[llave])){
						cont++;
					}
				}
				
				if(cont==0){
					mandarMensaje('Correcto');
				}
				else
					mandarMensajeError('No corresponden los puestos presupuestados, con los capturados en pantalla');
			}
		}
		
		$('#b_presupuesto').click(function(){
			var id_depto = $('#s_departamentos').val();
			
			$.post('php/busca_presupuesto_actual_depto.php',{'id_depto':id_depto},function(data){
				var datos = JSON.parse(data);
				var num = datos[0];
				
				var html = '';
				$('#t_dialogo_presupuesto tbody').html('');
				for(var i=1;i<=num;i++){
					var dato = datos[i];
					html = "<tr><td>"+dato.oficiales+"</td><td>"+dato.puesto+"</td></tr>";
					$('#t_dialogo_presupuesto tbody').append(html);
				}
				$('#modal_presupuesto').modal('show');
			});
			
			
		});
		
		//------- funcionamiento de modal edicion-------
		
		$('.grupo_cadena2').change(function(){
			var num = $('#i_pivote').val();
			num--;
			var cadena = $('#i_cadena').val();
			
			var cad1 = cadena.substr(0,num);
			var aux = cadena.substr(num,1);
			var cad2 = cadena.substr(parseInt(num)+1,cadena.length);
			$('#span_crear_cadena2').html(cad1+'<b style="color:red">'+aux+'</b>'+cad2);
		});
		
		//------------------------------------------------
		
		$('#b_guardar_rol').click(function(){
			var cadena = $('#i_cadena').val();
			
			var info = {
			'id_registro':id_registro,
			'id_puesto':$('#editar_puestos').val(),
			'descr':$('#i_descripcion').val(),
			'horas':$('#i_horas').val(),
			'pivote':$('#i_pivote').val(),
			'cadena':cadena.toUpperCase()
			};
			
			$.post('php/cambia_registro_horario.php',info,function(data){
				
				if(data==1){
					
					$.post('php/delete_incidencias_horario.php',{'id_registro':id_registro},function(data2){
						
						if(data2==1){
							$.post('php/insert_incidencias_horario.php',{'id_registro':id_registro},function(data3){
								
								
								if(data3==1){
									obtiene_trabajadores();
									$('#modal_edicion_rol').modal('hide');
									mandarMensaje('Posicion Editada Correctamente');
								}
								else{
									mandarMensajeError("Error al Generar Incidencias: "+data);
								}
							});
						}
						else{
							mandarMensajeError("Error al borrar Incidencias: "+data);
						}
					});
					
				}
				else{
					mandarMensajeError("Error al cambiar Horario: "+data);
				}
			});
		});
		
		$('#b_liberar_posicion').click(function(){
			//liberar posicion
			
				var info = {
						'id_trab':id_empleado,
						'id_depto':$('#s_departamentos').val()};
						
				$.post('php/libera_incidencias_horario.php',{'id_registro':id_registro},function(data2){
					if(data2==1){
						$.post('php/libera_registro_horario.php',info,function(data){
							if(data==1){
								obtiene_trabajadores();
								obtiene_no_asignados();
								$('#modal_edicion_rol').modal('hide');
								
								mandarMensaje('Posicion Editada Correctamente');
							}else{
								mandarMensajeError("Error al liberar horario: "+data);
							}
						});
					}
					else{
						mandarMensajeError("Error al liberar incidencias: "+data2);
					}
				});		
			
		});
		
		$('#b_crear_nuevo_rol').click(function(){
			$('#crear_puestos').val(1);
			
			$('#crear_descripcion').val('');
			$('#crear_horas').val('');
			$('#crear_cadena').val('');
			$('#crear_pivote').val(1);
			$('#span_crear_cadena').html('');
			$('#modal_crear_rol').modal('show');
		});
		
		//------- funcionamiento de modal creacion-------
		
		$('.grupo_cadena').change(function(){
			var num = $('#crear_pivote').val();
			num--;
			var cadena = $('#crear_cadena').val();
			
			var cad1 = cadena.substr(0,num);
			var aux = cadena.substr(num,1);
			var cad2 = cadena.substr(parseInt(num)+1,cadena.length);
			$('#span_crear_cadena').html(cad1+'<b style="color:red">'+aux+'</b>'+cad2);
		});
		
		//------------------------------------------------
		
		$('#b_crear_rol').click(function(){
			var cadena = $('#crear_cadena').val();
			var info = {
				'id_puesto':$('#crear_puestos').val(),
				'id_depto':$('#s_departamentos').val(),
				'descr':$('#crear_descripcion').val(),
				'horas':$('#crear_horas').val(),
				'cadena':cadena.toUpperCase(),
				'pivote':$('#crear_pivote').val()
			};
			$.post('php/crea_registro_horario.php',info,function(data){
				var datos = JSON.parse(data);
				if(datos.status==1){
					var id_reg = datos.id_registro;
					
					$.post('php/insert_incidencias_horario.php',{'id_registro':id_reg},function(data2){
						if(data2==1){
							obtiene_trabajadores();
							$('#modal_crear_rol').modal('hide');
							mandarMensaje('Posicion Creada Correctamente');
						}
						else{
							mandarMensajeError('Error al crear Incidencias:'+data2);
						}
					});
					
				}else{
					mandarMensajeError('Error al crear Horario:'+data);
				}
					
			});
			
		});
		
		
		$('#crear_dias').change(function(){
			var dias = $(this).val();
			var html = '';
			for(var i = 0;i<parseInt(dias);i++){
				 html = html +"<input style='width:20px;' value=''>";
			}
			$('#td_crear_cadena').html(html);
		});
		
		$('#b_incidencias').click(function(){
			 validaRoles();
		});
	});
</script>

<style>
	body{
		background: #fefefe url('imagenes/trabajo1.jpg') no-repeat ;
		background-size: cover;
		}
	.hoy{
		color:red;
	}
	.td_dia{
		font-size: 10px;
	}
	.td_puesto{
		font-size: 10px;
	}
	.modal{
		z-index: 1041;
	}
	
	.fuera_depto td{
		color:red
	}
	#div_tabla{
		overflow-x: scroll;
		overflow-y: scroll;
	}
	
	#transparencia{
		position: absolute;
		top:0px;
		left: 0px;
		width: 100%;
		height: 100%;
		background-color: rgba(255,255,255,0.7);
	}
	#span_crear_cadena{
		font-size: 16px;
		padding: 0px,20px
	}
	
	#contenido {
			position: absolute;
			top: 2%;
			left: 2%;
			width: 96%;
			bottom: 2%;
			padding: 20px;
			
			background-color: rgba(238,238,238,0.8);
			border-radius: 10px;
			-moz-box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
            box-shadow: rgba(80,91,101,0.2) 2px 2px 2px 2px;
		
		}
		
	#t_dropdown{
		margin-bottom: 3%; 
		margin-top: 3%;
	}
	
	#div_contenedor{
		width: 100%;
	}
	
	#div_no_asignado{
		width: 9%;
		float:left;
	}
	#div_cont_table{
		max-height:200px;
		min-height:130px;
		border: 1px solid #fff;
		margin-right:3%;
		background-color: white;
		overflow-x: hidden; 
		overflow-y:scroll; 
	}
	
	#div_contenido{
		width: 90%;
		float:right;
	}	
	
	#div_tabla{
		/*border-left: 1px solid #fff;
		border-right: 1px solid #fff;
		border-bottom: 1px solid #fff;*/
		overflow-x: hidden; 
		overflow-y:scroll; 
		padding-top:1px;
		max-height:370px;
		min-height:370px;
	}
	
	#d_titulo{
		position:absolute;
		top:30px;
		right:500px;
		font-size: 30px;
	}
	
	#d_barra_estado{
		position: absolute;
		bottom: 30px;
		left: 30px;
		width: 350px;
		height:100px;
		background-color: rgba(255,255,255,0.5);
		border-bottom: none;
		border-right: none;
		border-top:solid 2px #dedede;
		border-left:solid 1px #dedede;
		border-radius:5px;
		padding: 3px;
	}
</style>

<body>
	<div id="transparencia">
		
	</div>
	
	<div id="contenido">
		
		<div class="dropdown" id="t_dropdown">
			
			<select id="s_departamentos" name="s_departamentos" class="form-control form-control-sm" autocomplete="off" style="width:40%;"></select>
			<!-- aqui change -->
		</div>
		
		<div id="d_titulo">
			ROLES
		</div>
		
		<div id="div_contenedor">
				<div id="div_no_asignado">
					<h5>No Asignado</h5>
					<div id="div_cont_table">
						<table id="t_no_asignado" class="table table-striped">
							<tbody></tbody>
						</table>
					</div>		
				</div>
				<div id="div_contenido">
					
							
					<div  class="table-responsive" id="div_tabla">
						<table id="t_departamentos" class="table table-striped table" border="0">
							<thead>
								
							</thead>	
							<tbody></tbody>
						</table>
					</div>
				</div>
		</div>
		<div id="d_barra_estado">
			
		</div>
			<table width="60%" border="0" style="margin-top: 37%; margin-left: 40%;">
				<tr>
					<td align="left">
						<button type="button" class="btn btn-primary " id="b_presupuesto">Presupuesto</button>
					</td>
					<td align="left">
						<button type="button" class="btn btn-primary " id="b_crear_nuevo_rol">Agregar Posicion</button>
					</td>
				</tr>
			</table>
		</div>
		
	<!--  Inicio de Dialogos  -->
		
		<div class="modal fade" id="modal_edicion_rol" tabindex="-1" role="dialog" aria-labelledby="modal_label_edicion" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modal_label_edicion">Edicion de Rol</h4>
		      </div>
		      <div class="modal-body table-responsive">
		        <table id="t_dialogo_edicion" class="table table-bordered">
		        	<tbody>
		        		<tr>
		        			<td>Posicion:</td><td id="td_posicion"><select id="editar_puestos"></select></td>
		        		</tr>
		        		<tr>
		        			<td>Descripcion:</td><td ><input id="i_descripcion"></td>
		        		</tr>
		        		<tr>
		        			<td>Horas:</td><td><input class='input_num' id="i_horas"></td>
		        		</tr>
		        		
		        		<tr><td><span>Cadena:</span></td><td><input class='grupo_cadena2' id="i_cadena"></td></tr>
		        		<tr>
		        			<td >Indicar posicion en la cadena del dia de hoy:</td><td><input class='grupo_cadena2' id="i_pivote"><span id="span_crear_cadena2"></span></td>
		        		</tr>
		        	</tbody>
		        	<tfoot>
		        		<tr>
		        			<td colspan="2">
		        				<button type="button" id="b_liberar_posicion" class="btn btn-primary">Liberar</button>
		        			</td>
		        		</tr>
		        	</tfoot>
		        </table>
		      </div>
		      <div class="modal-footer">
		      	
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		        <button type="button" class="btn btn-primary" id="b_guardar_rol" >Guardar</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		
		<div class="modal fade" id="modal_crear_rol" tabindex="-1" role="dialog" aria-labelledby="modal_label_creacion" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modal_label_edicion">Creacion de Rol</h4>
		      </div>
		      <div class="modal-body table-responsive">
		        <table id="t_dialogo_edicion" class="table table-bordered">
		        	<tbody>
		        		<tr>
		        			<td>Posicion:</td><td id="td_posicion"><select id="crear_puestos"></select></td>
		        		</tr>
		        		<tr>
		        			<td>Descripcion:</td><td ><input id="crear_descripcion"></td>
		        		</tr>
		        		<tr>
		        			<td>Horas:</td><td ><input class="input_num" id="crear_horas"></td>
		        		</tr>
		        		<tr>
		        			<td>
		        				<span>Cadena:</span></td><td><input class='grupo_cadena' id="crear_cadena">
		        			</td>
		        		</tr>
		        		
		        		<tr>
		        			<td >Indicar posicion en la cadena del dia de hoy:</td><td><input class='input_num grupo_cadena' id="crear_pivote"><span id="span_crear_cadena"></span></td>
		        		</tr>
		        	</tbody>
		        </table>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		        <button type="button" class="btn btn-primary" id="b_crear_rol" >Guardar</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		
		<div class="modal fade" id="modal_presupuesto" tabindex="-1" role="dialog" aria-labelledby="modal_label_presupuesto" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modal_label_presupuesto">Presupuesto</h4>
		      </div>
		      <div class="modal-body table-responsive">
		        <table id="t_dialogo_presupuesto" class="table table-bordered">
		        	<thead>
		        		<tr>
		        			<td>Cantidad</td>
		        			<td>Puesto</td>
		        		</tr>
		        	</thead>
		        	<tbody>
		        		
		        	</tbody>
		        </table>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		<div class="modal fade" id="modal_cambiar_trabajador" tabindex="-1" role="dialog" aria-labelledby="modal_label_cambiar_trabajador" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modal_label_cambiar_trabajador">Cambiar Trabajador</h4>
		      </div>
		      <div class="modal-body table-responsive">
		        <table id="t_dialogo_cambiar_trabajador" class="table table-bordered">
		        	<thead>
		        		<tr>
		        			<td>Trabajador</td>
		        			<td>Descripcion</td>
		        			<td>Puesto</td>
		        		</tr>
		        	</thead>
		        	<tbody>
		        		
		        	</tbody>
		        </table>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		<div class="modal fade" id="modal_borrar_horario" tabindex="-1" role="dialog" aria-labelledby="modal_label_borrar" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modal_label_presupuesto">Borrar Registro</h4>
		      </div>
		      <div class="modal-body table-responsive">
		        <table id="t_dialogo_presupuesto" class="table table-bordered">
		        	<tbody>
		        		<tr>
		        			<td class="cen"><h4>¿Esta seguro que desea BORRAR el registro?</h4></td>
		        		</tr>
		        		<!--
		        		<tr>
		        			<td class="cen">
		        				A partir de que fecha:
		        			</td>
		        		</tr>
		        		<tr>
		        			<td class="cen">
		        				<input id="i_fecha_borrar" class="datepicker" />
		        			</td>
		        		</tr>
		        		-->
		        	</tbody>
		        </table>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        <button type="button" class="btn btn-primary" id="b_borrar_registro" >Borrar</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		<div class="modal fade" id="modal_aplicar_cambios" tabindex="-1" role="dialog" aria-labelledby="modal_label_aplicar_cambios" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modal_label_presupuesto">Aplicar Cambios</h4>
		      </div>
		      <div class="modal-body table-responsive">
		        <table id="t_dialogo_presupuesto" class="table table-bordered">
		        	<tbody>
		        		<tr>
		        			<td class="cen"><h4>Se aplicaran los cambios registrados</h4></td>
		        		</tr>
		        		<tr>
		        			<td class="cen">
		        				A partir de que fecha:
		        			</td>
		        		</tr>
		        		<tr>
		        			<td class="cen">
		        				<input id="i_fecha_aplicar" class="datepicker" />
		        			</td>
		        		</tr>
		        	</tbody>
		        </table>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        <button type="button" class="btn btn-primary" id="b_aplicar_cambios" >Aplicar Cambios</button>
		      </div>
		    </div>
		  </div>
		</div>
</body>
</html>